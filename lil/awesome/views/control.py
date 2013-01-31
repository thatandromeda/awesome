from lil.awesome.models import Organization
from lil.awesome.forms import OrganizationForm

from django.core.context_processors import csrf
from django.http import HttpResponseRedirect
from django.shortcuts import render_to_response
from django.core.urlresolvers import reverse

def home(request):
    """Control (user admin site) landing page"""
    
    org = Organization.objects.get(slug=request.META['subdomain'])
    
    context = {
            'user': request.user,
            'organization': org,
        }
    
    return render_to_response('control.html', context)

def org(request):
    """Users can control (admin) their org from here"""

    org = Organization.objects.get(slug=request.META['subdomain'])
    print org
    
    if request.method == 'POST':
        submitted_form = OrganizationForm(request.POST, instance=org)
        
        if submitted_form.is_valid():
            print 'is valid'
            submitted_form.save()
            print 'saved'
            return HttpResponseRedirect(reverse('control_org'))
        else:
            context = {
                'user': request.user,
                'organization': org,
                'form': submitted_form,
            }
            context.update(csrf(request))    
            return render_to_response('control-org.html', context)
            
    else:  
        form = OrganizationForm(instance=org)
        context = {
            'user': request.user,
            'organization': org,
            'form': form,
        }
        context.update(csrf(request))    
        return render_to_response('control-org.html', context)