Smiffony
========

My custom PHP Framework based on Symfony components.

I am using the following tutorial from Fabien Potencier's blog as a guide to implementing a framework on top of Symfony components:
http://fabien.potencier.org/article/50/create-your-own-framework-on-top-of-the-symfony2-components-part-1
My aim is to get a better understanding of how Symfony2 works, rather than just how to use it as a black-box framework.

I am building this on stack of Nginx and PHP-FPM instead of my more familiar Apache 2.2, and my impressions so far are good. I will probably have to get this framework running on Apache soon, so that I can run performance comparisons (for science!).

I have now completed the tutorial, and will now be looking to incorporate the Smiffony framework into some other projects.

The code contains a very simple sample app to check that the framework is working correctly - going to "http://www.example.com/is_leap_year/{YEAR}" will figure out if {YEAR} is a leapyear or not, and show the answer on the screen.
