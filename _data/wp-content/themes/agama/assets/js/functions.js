var THEMEVISION = THEMEVISION || {};

(function($) {
	
	"use strict";
	
	THEMEVISION.initialize = {

		init: function(){
			
			THEMEVISION.initialize.responsiveClasses();
			THEMEVISION.initialize.slider();
            THEMEVISION.initialize.blogGridIsotope();
            THEMEVISION.initialize.blogInfiniteScroll();
			THEMEVISION.initialize.goToTop();
			
		},
		
		responsiveClasses: function(){
			var jRes = jRespond([
				{
					label: 'smallest',
					enter: 0,
					exit: 575
				},{
					label: 'handheld',
					enter: 576,
					exit: 767
				},{
					label: 'tablet',
					enter: 768,
					exit: 991
				},{
					label: 'laptop',
					enter: 992,
					exit: 1199
				},{
					label: 'desktop',
					enter: 1200,
					exit: 10000
				}
			]);
			jRes.addFunc([
				{
					breakpoint: 'desktop',
					enter: function() { $body.addClass('device-xl'); },
					exit: function() { $body.removeClass('device-xl'); }
				},{
					breakpoint: 'laptop',
					enter: function() { $body.addClass('device-lg'); },
					exit: function() { $body.removeClass('device-lg'); }
				},{
					breakpoint: 'tablet',
					enter: function() { $body.addClass('device-md'); },
					exit: function() { $body.removeClass('device-md'); }
				},{
					breakpoint: 'handheld',
					enter: function() { $body.addClass('device-sm'); },
					exit: function() { $body.removeClass('device-sm'); }
				},{
					breakpoint: 'smallest',
					enter: function() { $body.addClass('device-xs'); },
					exit: function() { $body.removeClass('device-xs'); }
				}
			]);
		},
		
		particles: function( $circles_color, $lines_color ) {
			if( $( '#particles-js' ).hasClass( 'agama-particles' ) ) {
				particlesJS('particles-js', {
					"particles": {
					  "number": {
						"value": 80,
						"density": {
						  "enable": true,
						  "value_area": 800
						}
					  },
					  "color": {
					  "value": $circles_color
					  },
					  "shape": {
						"type": "circle",
						"stroke": {
						  "width": 0,
						  "color": $circles_color
						},
						"polygon": {
						  "nb_sides": 5
						},
						"image": {
						  "src": "img/github.svg",
						  "width": 100,
						  "height": 100
						}
					  },
					  "opacity": {
						"value": 0.5,
						"random": false,
						"anim": {
						  "enable": false,
						  "speed": 1,
						  "opacity_min": 0.1,
						  "sync": false
						}
					  },
					  "size": {
						"value": 5,
						"random": true,
						"anim": {
						  "enable": false,
						  "speed": 40,
						  "size_min": 0.1,
						  "sync": false
						}
					  },
					  "line_linked": {
						"enable": true,
						"distance": 150,
						"color": $lines_color,
						"opacity": 0.4,
						"width": 1
					  },
					  "move": {
						"enable": true,
						"speed": 6,
						"direction": "none",
						"random": false,
						"straight": false,
						"out_mode": "out",
						"attract": {
						  "enable": false,
						  "rotateX": 600,
						  "rotateY": 1200
						}
					  }
					},
					"interactivity": {
					  "detect_on": "canvas",
					  "events": {
						"onhover": {
						  "enable": true,
						  "mode": "repulse"
						},
						"onclick": {
						  "enable": false,
						  "mode": "push"
						},
						"resize": true
					  },
					  "modes": {
						"grab": {
						  "distance": 400,
						  "line_linked": {
							"opacity": 1
						  }
						},
						"bubble": {
						  "distance": 400,
						  "size": 40,
						  "duration": 2,
						  "opacity": 8,
						  "speed": 3
						},
						"repulse": {
						  "distance": 200
						},
						"push": {
						  "particles_nb": 4
						},
						"remove": {
						  "particles_nb": 2
						}
					  }
					},
					"retina_detect": true,
					"config_demo": {
					  "hide_card": false,
					  "background_color": "#b61924",
					  "background_image": "",
					  "background_position": "50% 50%",
					  "background_repeat": "no-repeat",
					  "background_size": "cover"
					}
				});
			}
		},
		
		slider: function() {
			if( agama.slider_enable == true ) {
				if( agama.headerStyle == 'transparent' && true == agama.is_admin_bar_showing ) {
					var $height = THEMEVISION.initialize.height() - 32;
				} else if( agama.headerStyle == 'transparent' && ! agama.is_admin_bar_showing ) {
					var $height = THEMEVISION.initialize.height();
				}
				
				if( agama.headerStyle == 'default' && true == agama.is_admin_bar_showing ) {
					var $height = THEMEVISION.initialize.height() - 32 - $header.height();
				} else if( agama.headerStyle == 'default' && ! agama.is_admin_bar_showing ) {
					var $height = THEMEVISION.initialize.height() - $header.height();
				}
				
				if( agama.headerStyle == 'sticky' && true == agama.is_admin_bar_showing ) {
					var $height = THEMEVISION.initialize.height() - 32 - $header.height();
				} else if( agama.headerStyle == 'sticky' && ! agama.is_admin_bar_showing ) {
					var $height = THEMEVISION.initialize.height() - $header.height();
				}
				
				if( agama.slider_height > 0 ) {
					var $height = agama.slider_height;
				}
				
				if( $('#agama_slider').hasClass('camera_wrap') ) {
					$slider.camera({
						height: $height + 'px',
						loader: 'bar',
						loaderColor: agama.primaryColor,
						overlay: false,
						fx: 'simpleFade',
						time: agama.slider_time,
						pagination: false,
						thumbnails: false,
						transPeriod: 1000,
						overlayer: true,
						playPause: false,
						hover: false,
					});
				}
				// If Particles Enabled
				if( agama.slider_particles == true ) {
					THEMEVISION.initialize.particles( agama.slider_particles_circle_color, agama.slider_particles_lines_color );
				}
			}
		},
        
        blogGridIsotope: function() {
            if( agama.blog_layout == 'grid' && ! $('body').hasClass('single-post') && $('div.article-wrapper').hasClass('grid-style') ) {
                $('#content').imagesLoaded( function(){
                    var $grid = $('#content').isotope({
                        itemSelector: 'div.article-wrapper'
                    });
                });
            }
        },
        
        blogInfiniteScroll: function() {
            if( agama.infinite_scroll == '1' && $('.navigation a').hasClass('next') ) {
                
                var $container = $('#content');
                
                $('.home.blog .navigation').hide();
                
                // If blog layout grid, setup isotope.
                if( agama.blog_layout == 'grid' ) {
                    $container.isotope({
                        itemSelector: '.article-wrapper'
                    });
                    var iso = $container.data('isotope');
                    $( window ).smartresize(function(){
                        $container.isotope({
                            itemSelector: '.article-wrapper',
                            masonry: { columnWidth: $container.width() / 5 }
                        });
                    });
                }
                
                // If blog layout == list && infinite trigger == button.
                if( agama.blog_layout == 'list' && agama.infinite_trigger == 'button' ) {
                    var options = {
                        path: '.navigation a.next',
                        append: '.article-wrapper',
                        button: '#infinite-loadmore',
                        scrollThreshold: false,
                        status: '.infscr-load-status',
                        history: false
                    };
                }
                // If blog layout == grid && infinite trigger == button.
                else if( agama.blog_layout == 'grid' && agama.infinite_trigger == 'button' ) {
                    var options = {
                        path: '.navigation a.next',
                        button: '#infinite-loadmore',
                        scrollThreshold: false,
                        append: '.article-wrapper',
                        outlayer: iso,
                        status: '.infscr-load-status',
                        history: false
                    };
                }
                // If blog layout == small_thumbs && infinite trigger == button.
                else if ( agama.blog_layout == 'small_thumbs' && agama.infinite_trigger == 'button' ) {
                    var options = {
                        path: '.navigation a.next',
                        append: '.article-wrapper',
                        button: '#infinite-loadmore',
                        scrollThreshold: false,
                        status: '.infscr-load-status',
                        history: false
                    };
                }
                // If blog layout == list && infinite trigger == auto.
                else if( agama.blog_layout == 'list' && agama.infinite_trigger == 'auto' ) {
                    var options = {
                        path: '.navigation a.next',
                        append: '.article-wrapper',
                        scrollThreshold: 50,
                        status: '.infscr-load-status',
                        history: false,
                        debug: true
                    };
                }
                // If blog layout == grid && infinite trigger == auto.
                else if( agama.blog_layout == 'grid' && agama.infinite_trigger == 'auto' ) {
                    var options = {
                        path: '.navigation a.next',
                        append: '.article-wrapper',
                        outlayer: iso,
                        scrollThreshold: 50,
                        status: '.infscr-load-status',
                        history: false,
                        debug: true
                    };
                }
                // If blog layout == small_thumbs && infinite trigger == auto.
                else if( agama.blog_layout == 'small_thumbs' && agama.infinite_trigger == 'auto' ) {
                    var options = {
                        path: '.navigation a.next',
                        append: '.article-wrapper',
                        scrollThreshold: 50,
                        status: '.infscr-load-status',
                        history: false,
                        debug: true
                    };
                }
                $container.infiniteScroll(options);
            }
        },
		
		goToTop: function(){
			$goToTopEl.click(function() {
				$('body,html').stop(true).animate({scrollTop:0},400);
				return false;
			});
		},
		
		goToTopScroll: function(){
            if($window.scrollTop() > 450) {
                $goToTopEl.slideDown();
            } else {
                $goToTopEl.slideUp();
            }
		},
		
		width: function() {
			return $window.width();
		},
		
		height: function() {
			if( $window.width() < 601 ) {
				return $window.height();
			} else {
				return $window.height();
			}
		}
	};
	
	THEMEVISION.header = {
		
		init: function() {
			
            THEMEVISION.header.contentDistance();
			THEMEVISION.header.superfish();
			THEMEVISION.header.mobilemenu();
            THEMEVISION.header.mobileMenuFocusLoop();
			THEMEVISION.header.header_image();
			
		},
		
		contentDistance: function() {
            var top = $header.outerHeight() - 1;
            
			if( agama.headerStyle == 'sticky' || agama.headerStyle == 'transparent' && ! $slider.length && ! $headerImage.length ) {
                $headerDistance.css('height', top);
			}
		},
        
        superfish: function() {
            
            // No menu location assigned fix
            if( $('div.agama-navigation').length ) {
                $('div.agama-navigation').children('ul').addClass('agama-navigation').unwrap();
            }
            
            THEMEVISION.header.menuInvert();
            
			if( !$().superfish ) {
                $body.addClass('no-superfish');
                console.log('superfish: Superfish not Defined.');
                return true;
            }
            
			$('body:not(.side-header) ul.agama-navigation:not(.on-click)').superfish({
                popUpSelector: 'ul',
                delay: 250,
                speed: 350,
                animation: {opacity:'show'},
                animationOut:  {opacity:'hide'},
                cssArrows: false
            });
		},
        
        menuInvert: function() {

			$('ul.agama-navigation ul').each( function( index, element ){
				var $menuChildElement = $(element),
					menuChildOffset = $menuChildElement.offset(),
					menuChildWidth = $menuChildElement.width(),
					menuChildLeft = menuChildOffset.left;
                
				if(windowWidth - (menuChildWidth + menuChildLeft) < 0) {
					$menuChildElement.addClass('menu-pos-invert');
				}
			});

		},
		
		topsocial: function(){
			if( $topSocialEl.length > 0 ){
				if( $body.hasClass('device-xl') || $body.hasClass('device-lg') ) {
					$topSocialEl.show();
					$topSocialEl.find('a').css({width: 40});

					$topSocialEl.find('.tv-text').each( function(){
						var $clone = $(this).clone().css({'visibility': 'hidden', 'display': 'inline-block', 'font-size': '13px', 'font-weight':'bold'}).appendTo($body),
							cloneWidth = $clone.innerWidth() + 52;
						$(this).parent('a').attr('data-hover-width',cloneWidth);
						$clone.remove();
					});

					$topSocialEl.find('a').hover(function() {
						if( $(this).find('.tv-text').length > 0 ) {
							$(this).css({width: $(this).attr('data-hover-width')});
						}
					}, function() {
						$(this).css({width: 40});
					});
				} else {
					$topSocialEl.show();
					$topSocialEl.find('a').css({width: 40});

					$topSocialEl.find('a').each(function() {
						var topIconTitle = $(this).find('.tv-text').text();
						$(this).attr('title', topIconTitle);
					});

					$topSocialEl.find('a').hover(function() {
						$(this).css({width: 40});
					}, function() {
						$(this).css({width: 40});
					});

					if( $body.hasClass('device-xs') ) {
						$topSocialEl.hide();
						$topSocialEl.slice(0, 8).show();
					}
				}
			}
		},
		
		mobilemenu: function(){
			$(".mobile-menu ul.menu > li.menu-item-has-children").each(function(index) {
				var menuItemId = "mobile-menu-submenu-item-" + index;
				$('.mobile-menu ul.sub-menu').id = index;
				$('<button class="tv-dropdown-toggle tv-collapsed" data-toggle="tv-collapse" data-target="#' + menuItemId + '"></button>').insertAfter($(this).children("a"));
				
				$(this).children("ul").prop("id", menuItemId);
				$(this).children("ul").addClass("tv-collapse");

				$("#" + menuItemId).on("show.tv.collapse", function() {
					$(this).parent().addClass("open");
				});
				$("#" + menuItemId).on("hidden.tv.collapse", function() {
					$(this).parent().removeClass("open");
				});
			});
			$('.mobile-menu-toggle').click(function() {
				$(this).toggleClass('is-active');
				$('nav.mobile-menu').slideToggle();
			});
			$window.on('resize', function(){
				if( $window.width() > 992 ) {
					$('nav.mobile-menu').hide();
				}
			});
		},
        
        /**
         * Mobile Menu Focus Loop
         *
         * Loop through the mobile menu with keyboard.
         *
         * @since 1.5.3
         */
        mobileMenuFocusLoop: function() {
            var _doc = document, elements, selector, lastEl, firstEl, activeEl, tabKey, shiftKey,
                menu = $('#masthead');
            
            if( ! menu ) {
                return false;
            }

            _doc.addEventListener( 'keydown', function( event ) {
                if( $('#agama-mobile-nav').is(':visible') ) {
                    selector = 'a:not([rel="home"]), button';
                    elements = $(menu).find( selector ).filter( ':visible' );
                    elements = Array.prototype.slice.call( elements );

                    lastEl      = elements[ elements.length - 1 ];
                    firstEl     = elements[0];
                    activeEl    = _doc.activeElement;
                    tabKey      = event.keyCode === 9;
                    shiftKey    = event.shiftKey;

                    if ( ! shiftKey && tabKey && lastEl === activeEl ) {
                        event.preventDefault();
                        firstEl.focus();
                    }

                    if ( shiftKey && tabKey && firstEl === activeEl ) {
                        event.preventDefault();
                        lastEl.focus();
                    }
                }
            } );
        },
		
		header_image: function() {
			if( agama.headerImage && agama.header_image_particles == true ) {
				THEMEVISION.initialize.particles( agama.header_img_particles_c_color, agama.header_img_particles_l_color );
			}
		}
		
	};
	
	THEMEVISION.widgets = {
		
		init: function() {
			
			THEMEVISION.widgets.animations();
			
		},
		
		animations: function(){
            if( !$().appear ) {
				console.log('animations: Appear not Defined.');
				return true;
			}
			var $dataAnimateEl = $('[data-animate]');
			if( $dataAnimateEl.length > 0 ){
				if( $body.hasClass('device-xl') || $body.hasClass('device-lg') || $body.hasClass('device-md') ){
					$dataAnimateEl.each(function(){
						var element = $(this),
							animationDelay = element.attr('data-delay'),
							animationDelayTime = 0;

						if( animationDelay ) { animationDelayTime = Number( animationDelay ) + 500; } else { animationDelayTime = 500; }

						if( !element.hasClass('animated') ) {
							element.addClass('not-animated');
							var elementAnimation = element.attr('data-animate');
							element.appear(function () {
								setTimeout(function() {
									element.removeClass('not-animated').addClass( elementAnimation + ' animated');
								}, animationDelayTime);
							},{accX: 0, accY: -120},'easeInCubic');
						}
					});
				}
			}
		}
		
	};
	
	THEMEVISION.extras = {
		
		init: function(){
			
			THEMEVISION.extras.tipsntabs();
			THEMEVISION.extras.customclasses();
			THEMEVISION.extras.bbPress();
			THEMEVISION.extras.contact7form();
			
		},
		
		tipsntabs: function(){
			
			$('[data-toggle="tv-tooltip"]').tooltip();
  
			$('#tabs a:first').tab('show'); // Show first tab by default
		  
			$('#tabs a').click(function (e) {
				e.preventDefault()
				$(this).tab('show');
			})
			
		},
		
		customclasses: function(){
			
			if( $('a').hasClass('comment-reply-link') ) {
				$('a.comment-reply-link').append('<i class="fa fa-reply"></i>');
			}
			
		},
		
		bbPress: function(){
			
			$('#bbp_search').addClass('sm-form-control');
			$('#bbp_topic_title').addClass('sm-form-control');
			
		},
		
		contact7form: function() {
            if( $('input').hasClass('wpcf7-submit') ) {
                $('.wpcf7-submit').addClass('button button-3d');
            }
		}
		
	};
	
	THEMEVISION.isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
		BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
		iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
		Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
		Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
		any: function() {
			return (THEMEVISION.isMobile.Android() || THEMEVISION.isMobile.BlackBerry() || THEMEVISION.isMobile.iOS() || THEMEVISION.isMobile.Opera() || THEMEVISION.isMobile.Windows());
		}
	};
	
	// Document on resize
	THEMEVISION.documentOnResize = {
		
		init: function(){
			
			var t = setTimeout( function(){
				
                THEMEVISION.header.topsocial();
                
			}, 500 );
            
            THEMEVISION.header.contentDistance();
			
		}
		
	};
	
	// Document on ready
	THEMEVISION.documentOnReady = {
		
		init: function(){
			
			THEMEVISION.initialize.init();
			THEMEVISION.header.init();
			THEMEVISION.widgets.init();
			THEMEVISION.extras.init();
			THEMEVISION.documentOnReady.windowscroll();
			
		},
		
		windowscroll: function(){
			
			$window.on( 'scroll', function(){
				
				THEMEVISION.initialize.goToTopScroll();
				
				// Sticky Header Class
				if(jQuery(this).scrollTop() > 1){ 
					
					// If sticky header & top navigation enabled
					if( agama.headerStyle == 'sticky' && agama.top_navigation ) {
						$topbar.hide();
					}
					
                    if( $header.hasClass('header_v1') && ! $body.hasClass('device-xs') || $header.hasClass('header_v3') && ! $body.hasClass('device-xs') ) {
					   $header.addClass("shrinked");
                    }
				}else{
					
					// If sticky header & top navigation enabled
					if( agama.headerStyle == 'sticky' && agama.top_navigation ) {
						$topbar.show();
					}
					
					$header.removeClass("shrinked");
				}

			});
			
		}
		
	};
	
	// Document on load
	THEMEVISION.documentOnLoad = {
		
		init: function(){
			
			THEMEVISION.header.topsocial();
		
		}
		
	};
	
	var $window	 		= $(window),
		$document		= $(document),
        windowWidth     = $window.width(),
		$body	 		= $('body'),
		$wpadminbar		= $('#wpadminbar'),
		$topbar			= $('.agama-top-nav-wrapper'),
		$header			= $('#masthead'),
		$header_v1		= $('#masthead.header_v1'),
        $header_v2      = $('#masthead.header_v2'),
        $header_v3      = $('#masthead.header_v3'),
		$headerImage	= $('.header-image'),
        $headerDistance = $('#agama-header-distance'),
		$slider			= $('#agama_slider'),
		$topSocialEl 	= $('#agama-top-social').find('li'),
		$goToTopEl		= $('#toTop');
		
	$(document).ready( THEMEVISION.documentOnReady.init );
	$window.load( THEMEVISION.documentOnLoad.init );
	$window.on( 'resize', THEMEVISION.documentOnResize.init );
	
})(jQuery);