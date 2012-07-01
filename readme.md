# Creative Commons License for WordPress #

This plugins adds the Creative Commons license of choice to a website's metadata.


## Configuration ##

The plugin provides no UI for configuring it.  Instead, you must define a PHP
constant named `CC_LICENSE`.  This is most easily done by adding a snippet like
the following to your wp-config.php file:

    define('CC_LICENSE', 'http://creativecommons.org/licenses/by-nc-sa/3.0/');


## Questions ##

**What exactly does this plugin add to my site?**

It adds a `<link rel="license" />` element to each page of your site.  It also
adds an appropriate element to the XML feeds (rdf, rss, atom) for your site.

**Can I override the license for a specific post?**

Yes, a filter named `cc_license` is called before returning the license.  You
can override that value under whatever circumstances you want.
