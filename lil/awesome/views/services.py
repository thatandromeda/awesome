import httplib, json, logging, urllib2
from StringIO import StringIO

from lil.awesome.models import Branch, Item, Organization

from django.http import HttpResponse
from django.views.decorators.csrf import csrf_exempt
from django.utils.http import urlquote

from lxml import etree


logger = logging.getLogger(__name__)

try:
    from lil.awesome.local_settings import *
except ImportError, e:
    logger.error('Unable to load local_settings.py:', e)

"""
Some services. These often times are translators between front end, AJAXy things, and our API/Model.
"""

@csrf_exempt
def new_item(request):
    """Something coming in from our scan page"""
    
    if 'barcode' not in request.POST:
        return HttpResponse(status=400)
    
    barcode = request.POST["barcode"]
    branch = request.POST["branch"]
        
    # We have the barcode, we need to determine if it's an isbn or an institution barcode or ... 
    
    
    # If we are using the harvard lookup system
    
    org = Organization.objects.get(slug=request.META['subdomain'])
    branch = Branch.objects.get(name=branch)
    
    message_to_return = "No Title"
    
    if org.service_lookup == "worldcat":
        try:
            message_to_return = _item_from_worldcat(barcode, branch)
        except NameError:
            return HttpResponse("Something went wonky", status=500)
        
    if org.service_lookup == "hollis":
        try:
            message_to_return = _item_from_hollis(barcode, branch)
        except NameError:
            return HttpResponse("Something went wonky", status=500)

    
    return HttpResponse(message_to_return, status=200)

def _item_from_hollis(barcode, branch):
    
    url = 'http://webservices.lib.harvard.edu/rest/classic/barcode/cite/' + barcode;
    
    req = urllib2.Request(url)
    req.add_header("accept", "application/json")
    
    response = None
    
    try: 
        f = urllib2.urlopen(req)
        response = f.read()
        f.close()
    except urllib2.HTTPError, e:
        print('HTTPError = ' + str(e.code))
    except urllib2.URLError, e:
        print('URLError = ' + str(e.reason))
    except httplib.HTTPException, e:
        print('HTTPException')
    except Exception:
        import traceback
        print('generic exception: ' + traceback.format_exc())
    
    jsoned_response = json.loads(response)
    
    hollis_id = jsoned_response["rlistFormat"]["hollis"]["hollisId"]
    
    massaged_hollis_id = hollis_id[:9].zfill(9)
    
        
     # Let's assume that the above works. I give it a barcode and it gives me a hollis id
    url = 'http://librarycloud.harvard.edu/v1/api/item/?filter=id_inst:' + massaged_hollis_id;
    req = urllib2.Request(url)
    
    response = None
    
    try: 
        f = urllib2.urlopen(req)
        response = f.read()
        f.close()
    except urllib2.HTTPError, e:
        print('HTTPError = ' + str(e.code))
    except urllib2.URLError, e:
        print('URLError = ' + str(e.reason))
    except httplib.HTTPException, e:
        print('HTTPException')
    except Exception:
        import traceback
        print('generic exception: ' + traceback.format_exc())
        
       
    jsoned_response = json.loads(response)
    
    docs = jsoned_response['docs'][0]
    
    physical_format = 'book'
    if 'video' in docs['format']:
        physical_format = 'videofilm'
        cover_art = _get_rt_movie_poster(docs['title'])
    elif 'sound' in docs['format']:
        physical_format = 'soundrecording'

    
    
    item = Item(branch=branch,
                title=docs['title'],
                creator=docs['creator'][0],
                unique_id=docs['id_inst'],
                catalog_id=docs['id_inst'],
                isbn=docs['id_isbn'][0],
                physical_format=docs['format'],)
    
    item.save()
    
    return docs['title']
    
def _item_from_worldcat(barcode, branch):
    """Given a barcode, get metadata from worldcat"""
    
    url = "http://www.worldcat.org/webservices/catalog/search/sru?query=srw.sn%3D%22" + barcode + "&wskey=" + WORLDCAT["KEY"] + "&servicelevel=full";
    req = urllib2.Request(url)
    
    response = None
    
    try: 
        f = urllib2.urlopen(req)
        response = f.read()
        f.close()
    except urllib2.HTTPError, e:
        print('HTTPError = ' + str(e.code))
    except urllib2.URLError, e:
        print('URLError = ' + str(e.reason))
    except httplib.HTTPException, e:
        print('HTTPException')
    except Exception:
        import traceback
        print('generic exception: ' + traceback.format_exc())
    
    
    parser = etree.XMLParser(ns_clean=True, recover=True)
    tree = etree.parse(StringIO(response), parser)
    
    unique_id= None
    unique_id_list = tree.xpath('//*[@tag="001"]/text()')
    if unique_id_list:
        unique_id = unique_id_list[0]
    else:
        raise NameError('Error getting Data')
    
    title = 'No title'
    title_list = tree.xpath('//*[@tag="245"]/*[@code="a"]/text()')
    if title_list:
        title = title_list[0]
    
    creator = 'No creator'
    creator_list = tree.xpath('//*[@tag="100"]/*[@code="a"]/text()')
    if creator_list:
        creator = creator_list[0]
        
    massaged_isbn = None
    isbn_list = tree.xpath('//*[@tag="020"]/*[@code="a"]/text()')
    if isbn_list:
        isbn = isbn_list[0]
        massaged_isbn = isbn.split()[0]
    
    cover_art = ''
    
    physical_format = 'book'
    
    formats = tree.xpath('//*[@tag="300"]/*/text()')
            
    if formats:
        for format in formats:
            if 'video' in format:
                physical_format = 'videofilm'
                cover_art = _get_rt_movie_poster(title)
                break
            elif 'sound' in format:
                physical_format = 'soundrecording'
                break

   
    item = Item(branch=branch,
                title=title,
                creator=creator,
                unique_id=unique_id,
                catalog_id=barcode,
                isbn=massaged_isbn,
                physical_format=physical_format,
                cover_art=cover_art,)
    
    
    item.save()
    
    return title

def _get_rt_movie_poster(title):
    """Try to get a poster url from rottent tomatoes"""
    
    url = "http://api.rottentomatoes.com/api/public/v1.0/movies.json?apikey=" + ROTTEN_TOMATOES['KEY'] + "&q="+ urlquote(title) + "&page_limit=1";
    req = urllib2.Request(url)
    
    response = None
    
    try: 
        f = urllib2.urlopen(req)
        response = f.read()
        f.close()
    except urllib2.HTTPError, e:
        print('HTTPError = ' + str(e.code))
    except urllib2.URLError, e:
        print('URLError = ' + str(e.reason))
    except httplib.HTTPException, e:
        print('HTTPException')
    except Exception:
        import traceback
        print('generic exception: ' + traceback.format_exc())
    
    jsoned_response = json.loads(response)
    print jsoned_response
    
    if 'movies' in jsoned_response:
        poster_url = jsoned_response['movies'][0]['posters']['profile']
        

    return poster_url
    
    