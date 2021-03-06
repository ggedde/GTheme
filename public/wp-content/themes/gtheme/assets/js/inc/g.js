/*
*  GTheme Common Object
*/

var g = {};

jQuery(function($){

    /////////////////////////////
    //  Variables
    /////////////////////////////

    g.scrollPos = 0;
    g.documentHeight = 0;
    g.windowHeight = 0;

    g.lastScrollPos = $(window).scrollTop();

    /////////////////////////////
    //  Functions
    /////////////////////////////

    g.isMobile = function()
    {
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            return true;
        }
        return false;
    }

    g.setCookie = function(cname, cvalue, exmin)
    {
        var d = new Date();
        if(exmin)
        {
            d.setTime(d.getTime() + (24*exmin*60*1000));
            var expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }
        else
        {
            document.cookie = cname + "=" + cvalue + ";path=/";
        }
    }

    g.getCookie = function(cname)
    {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++)
        {
            var c = ca[i];
            while (c.charAt(0) == ' ')
            {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0)
            {
                return c.substring(name.length, c.length);
            }
        }
        return '';
    }

    g.removeTelLinksForNonMobile = function()
    {
        if(!g.isMobile())
		{
			$('a').each(function(){
				var href = '';
				if(href = $(this).attr('href'))
				{
					if(href.indexOf('tel:') > -1)
					{
                        $(this).addClass('non-mobile');
						$(this).removeAttr('href');
					}
				}
			});
		}
    }


    /*
    *  Store the Scroll Position as a Variable
    *  for other functions
    */

    g.setScrollVars = function()
    {
        g.scrollPos = $(window).scrollTop();
    }



    /*
    *  Scrolling function to animate to a
    *  selector, with optional offset
    */

	g.scrollTo = function(selector, offset)
    {
		var element;

		if(typeof selector == 'string')
        {
			element = $(selector);
		}
        else
        {
			element = selector;
		}

        if(typeof offset === 'undefined')
        {
			offset = 0;
		}

		$('html, body').animate({
			scrollTop: (element.offset().top - offset)
		}, 500);
	}



    /*
    *  Store the Scroll Position as a Variable
    *  for other functions
    */

    g.setHeightVars = function()
    {
        g.documentHeight = $(document).height();
        g.windowHeight = $(window).height();
    }



    /*
    *  Add Taget="_blank" to links that are external
    *  Also add class "external-link"
    */

    g.filterLinks = function()
	{
		/* Make all External Links and PDF's open in a new Tab */
	    var host = new RegExp('/' + window.location.host + '/');

	    $('a').each(function()
        {
            if(!$(this).attr('target'))
            {
    		    if ((!host.test(this.href) &&
                this.href.slice(0, 1) != "/" &&
                this.href.slice(0, 1) != "#" &&
                this.href.slice(0, 4) != "tel:" &&
                this.href.slice(0, 7) != "mailto:" &&
                this.href.slice(0, 11) != "javascript:" &&
                this.href.slice(0, 1) != "?") || this.href.indexOf('.pdf') > 0)
                {
    			    $(this).attr({ 'target': '_blank', 'rel': 'noopener' });
    			    $(this).addClass('external-link');
    		    }
            }
		});
	}



    /*
    *  Add Class to HTML Tag to specify the Scroll direction
    */

    g.updateScrollClasses = function(threshold)
    {
        if(typeof(threshold) === 'undefined')
        {
            threshold = 0;
        }

        // Update Document Height
        g.documentHeight = $(document).height();

        if(!g.scrollPos)
        {
            $('html').addClass('scroll-top');
        }
        else
        {
            $('html').removeClass('scroll-top');
        }

        // Prevent Scroll Past Bottom issues with browsers
        if(g.scrollPos < (g.documentHeight - g.windowHeight))
        {
            if(g.scrollPos > threshold)
            {
                if (!$('html').hasClass('scroll-down') && g.scrollPos >= g.lastScrollPos)
                {
                    $('html').removeClass('scroll-up').addClass('scroll-down');
                }
                else if(!$('html').hasClass('scroll-up') && g.scrollPos < g.lastScrollPos)
                {
                    $('html').removeClass('scroll-down').addClass('scroll-up');
                }

                if(!$('html').hasClass('scrolled'))
                {
                    $('html').addClass('scrolled');
                }
            }
            else if ($('html').hasClass('scroll-up') || $('html').hasClass('scroll-down') || $('html').hasClass('scroll-down'))
            {
                $('html').removeClass('scroll-up scroll-down scrolled');
            }

            g.lastScrollPos = g.scrollPos;
        }
    }


    g.addDropDownsToSubMenus = function()
    {
        $('li.menu-item-has-children > a').after('<span class="nav-dropdown"></span>');
        $('.nav-dropdown').on('click', function(){
            $(this).parent().toggleClass('open');
        });
    }


    g.addListenerToMobileMenuButton = function()
    {
        $('.button-mobile-menu').on('click', function(){
            $('html').toggleClass('mobile-menu-open');
        });

        $('.global-content').on('click', function()
        {
            if($('html').hasClass('mobile-menu-open'))
            {
                $('html').removeClass('mobile-menu-open');
            }
        });
    }

    g.updateInputItems = function()
    {
        $('.input-wrapper-checkbox input, .input-wrapper-radio input').each(function(){
            if($(this).is(':checked'))
            {
                $(this).closest('.input-wrapper').addClass('checked');
            }
            else
            {
                $(this).closest('.input-wrapper').removeClass('checked');
            }
        });
    }

    g.wrapInputItems = function()
    {
        $('input[type=checkbox]:not(.no-wrap)').wrap( "<span class='input-wrapper input-wrapper-checkbox'></span>" );
        $('input[type=radio]:not(.no-wrap)').wrap( "<span class='input-wrapper input-wrapper-radio'></span>" );
        $('input[type=submit]:not(.no-wrap)').wrap( "<span class='input-wrapper input-wrapper-submit'></span>" );
        $('select:not(.no-wrap)').wrap( "<span class='input-wrapper input-wrapper-select'></span>" );

        $('.input-wrapper-checkbox input, .input-wrapper-radio input').on('change', function(){
            g.updateInputItems();
        });

        g.updateInputItems();
	}
	
	g.isOverflown = function(el) 
	{
		var element=el[0];		
		return element.scrollHeight > element.clientHeight || element.scrollWidth > element.clientWidth;
	}

	g.updateOverflown = function()
	{
		$('[data-overflown-at]').each(function(){
			var overflownHeight = parseInt($(this).attr('data-overflown-at'));			
			if($(this).height() > overflownHeight)
			{
				$(this).css({
					'position': 'relative',
					'max-height': overflownHeight + 'px',
					'overflow': 'hidden'
				});
			}

			if(g.isOverflown($(this)))
			{
				$(this).addClass('overflown');
				$(this).after('<div class="show-all">Show All</div>');
			}
			else
			{
				$(this).removeClass('overflown');
				$(this).parent().find('.show-all').remove();
			}
		});
	}
});
