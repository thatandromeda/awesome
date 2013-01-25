class SubdomainMiddleware:
    def process_request(self, request):
        """Parse out the subdomain from the request"""
        # thanks to http://thingsilearned.com/2009/01/05/using-subdomains-in-django/
        request.subdomain = 'harvard'
        host = request.META.get('HTTP_HOST', '')
        host_s = host.replace('www.', '').split('.')
        if len(host_s) > 2:
            request.subdomain = ''.join(host_s[:-2])