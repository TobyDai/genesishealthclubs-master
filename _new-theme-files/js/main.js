;
(function() {

    'use strict';

    if ( ! Cedar )
        return false;


    Cedar.isHome = false;

    Cedar.animationOptions = function() {

        Cedar.animationOptions.scrollTop = window.pageYOffset;
        Cedar.animationOptions.header = Cedar.query('.site-header');
        Cedar.animationOptions.headerHeight = Cedar.animationOptions.header ? Cedar.animationOptions.header.offsetHeight : 0;

    };

    Cedar.updateTransformValue = function(value, offset) {
        value = Cedar.animationOptions.scrollTop * offset;
        value = value.toFixed(2);
        return value;
    };

    Cedar.transform = function(element, transform) {

        element.style.transform = transform;
    };

    Cedar.animateStuff = function() {

        Cedar.animationOptions.scrollTop = window.pageYOffset;

        if ( Modernizr && Modernizr.mq('(min-width: 48em)') ) {

            if (Cedar.animationOptions.scrollTop > Cedar.animationOptions.headerHeight * 0.5) {
                Cedar.classes.add(document.body, 'is-site-header-reduced');
            }
            else {
                Cedar.classes.remove(document.body, 'is-site-header-reduced');
            }
        } else if (Modernizr && Modernizr.mq('(max-width: 48em)')) {
            if ( Cedar.animationOptions.scrollTop > 5 ) {
                Cedar.classes.add(document.body, 'is-site-header-reduced');
            }
            else {
                Cedar.classes.remove(document.body, 'is-site-header-reduced');
            }
        }


    };

    Cedar.view = {
		enterStage: function () {
			let scrollTop = window.pageYOffset,
				offstage = Cedar.queryAll('.off-stage'),
				i = 0;

			for ( let j = 0; j < offstage.length; j++ ) {
				let item = offstage[j],
					itemTop = item.getBoundingClientRect().top + scrollTop,
					itemHeight = item.clientHeight,
					isInFrame = (scrollTop > itemTop - window.innerHeight);

				if ( itemTop < scrollTop )
					i = 0;


				if ( isInFrame ) {
					console.log('in-frame');
					setTimeout(function() {
						Cedar.classes.remove(item, 'off-stage');
					}, 200 * i);
					i++;
				}
			}
		}
    };

    Cedar.preload = {
        load: function(url) {
            if (url.match(/\.(jpeg|jpg|gif|png)$/) != null) {
                var img = new Image();
                img.src = url;
            }
        },
        init: function() {
            var preloads = Cedar.queryAll('[data-preload]'),
                pos = preloads.length;

            while (pos--) {
                if (!preloads[pos].hasAttribute('data-preload-loaded')) {
                    if (preloads[pos].hasAttribute('data-preload-media-query') && Modernizr) {
                        if (Modernizr.mq(preloads[pos].getAttribute('data-preload-media-query'))) {
                            Cedar.preload.load(preloads[pos].getAttribute('data-preload'));
                            preloads[pos].setAttribute('data-preload-loaded', true);
                        }
                    } else {
                        Cedar.preload.load(preloads[pos].getAttribute('data-preload'));
                        preloads[pos].setAttribute('data-preload-loaded', true);
                    }
                }
            }
        }
    };

    Cedar.suggest = {

        _li : function ( item, searchterm ) {

            /*if ( item._embedded )
                console.log( item._embedded['wp:featuredmedia'][0]);

            var ul = document.getElementById('cedar-suggest'),*/
            var image_url = item._embedded ? item._embedded['wp:featuredmedia'][0].media_details.sizes.thumbnail.source_url : '',
                html = '';
                //regexp = new RegExp( ul.getAttribute('data-cedar-term'), 'ig' );
            html = "<li data-cedar-suggest-item='" + JSON.stringify( item ) + "'>" + '<a href="' + item.link + '">';
            if ( image_url ) {
                html += '<img src="' + image_url + '">';
            }
            html += item.title.rendered + '</a></li>';

            return html;
        },

        request: function ( s ) {
            Cedar.requestPlainText({
                url: '/wp-json/wp/v2/product?_embed&per_page=15&search=' + s,
                success: function (response) {
                    Cedar.suggest.success(response);
                }
            });
        },

        success: function ( response ) {

            var data = JSON.parse( response ),
                ul = document.getElementById('cedar-suggest');
            ul.innerHTML = '';
            for ( var i = 0; i < data.length; i++ ) {
                ul.innerHTML += Cedar.suggest._li( data[i] );
            }
        },

        init: function (options) {

            if ( ! options.input )
                return;

            var ul = document.createElement('ul');

            ul.id = 'cedar-suggest_' + options.input.id;
            ul.className = 'cedar-suggest';

            if ( ! options.link ) {
                ul.className += ' cedar-suggest--no-link ';
            }

            options.input.setAttribute('autocomplete', 'off');
            options.input.setAttribute('autocorrect', 'off');
            options.input.setAttribute('autocapitalize', 'off');
            options.input.setAttribute('spellcheck', 'false');
            options.input.setAttribute('data-cedar-suggest', 'cedar-suggest_' + options.input.id);

            Cedar.dom.insertAfter( ul, options.input );

            Cedar.events.on( options.input, 'keyup', function () {
                if ( options.input.value.length > 2 ) {
                    Cedar.classes.add( ul, 'active' );
                    ul.setAttribute('data-cedar-term', options.input.value );
                    //Cedar.suggest.request( options.input.value );
                    Cedar.requestPlainText({
                        url: '/wp-json/wp/v2/' + options.postType + '?_embed&per_page=15&search=' + options.input.value,
                        success: function (response) {
                            var data = JSON.parse( response ),
                                ul = document.getElementById( options.input.getAttribute('data-cedar-suggest') );
                            ul.innerHTML = '';
                            for ( var i = 0; i < data.length; i++ ) {

                                var item = data[i],
                                    image_url = item._embedded ? item._embedded['wp:featuredmedia'][0].media_details.sizes.thumbnail.source_url : '',
                                    html = '';
                                    //regexp = new RegExp( ul.getAttribute('data-cedar-term'), 'ig' );
                                html = "<li class='cedar-suggest_item'><a href='" + item.link + "'  data-cedar-suggest-item='" + JSON.stringify( item ) + "'>";
                                if ( image_url ) {
                                    html += '<img src="' + image_url + '">';
                                }
                                html += item.title.rendered;
                                if ( options.serialize ) {
                                    html += '<span class="cedar-suggest_item_serialized">';
                                    for ( var prop in item[ options.serialize ] ) {
                                        html += item[ options.serialize ][ prop ] + ' ';
                                    }
                                    html += '</span>';
                                }
                                html += '</a></li>';

                                ul.innerHTML += html;
                                //ul.innerHTML += Cedar.suggest._li( data[i] );
                            }
                        }
                    });
                }
                else {
                    Cedar.classes.remove( ul, 'active' );
                }
            });

            Cedar.events.on( options.input, 'focus', function ( event ) {
                Cedar.classes.add( document.getElementById( options.input.getAttribute('data-cedar-suggest') ), 'active' );
            });

            Cedar.events.on( document, 'click', function ( event ) {
                if ( ! Cedar.dom.closest( event.target, 'cedar-suggest' ) && event.target != options.input )
                    Cedar.classes.remove( document.getElementById( options.input.getAttribute('data-cedar-suggest') ), 'active' );
            });
        }
    };

    /*
	 * Cookie handler (by Filament Group)
	 * https://github.com/filamentgroup/cookie/blob/master/cookie.js
	 */
	Cedar.cookie = function( name, value, days ){
        // if value is undefined, get the cookie value
        if( value === undefined ) {
            var cookiestring = "; " + document.cookie;
			var cookies = cookiestring.split( "; " + name + "=" );
			if ( cookies.length === 2 ){
				return cookies.pop().split( ";" ).shift();
			}
			return null;
		}
		else {
			// if value is a false boolean, we'll treat that as a delete
			if( value === false ) {
				days = -1;
			}
			var expires = "";
			if ( days ) {
				var date = new Date();
				date.setTime( date.getTime() + ( days * 24 * 60 * 60 * 1000 ) );
				expires = "; expires="+date.toGMTString();
			}
			document.cookie = name + "=" + value + expires + "; path=/";

		}
	};

    Cedar.notice = {
        close: function () {

        },
        init: function () {
            const notice = document.querySelector('.cedar-notice');

            if ( ! notice )
                return;

            const noticeId = notice.id;

            if ( ! Cedar.cookie('hide-cedar-notice__' + noticeId) ) {
                Cedar.classes.add(notice, 'is-active');
                Cedar.events.on(document.body, 'click', function (event) {
                    const self = event.target;
                    if ( Cedar.classes.contains(self, 'button') && Cedar.dom.closest(self, 'cedar-notice') ) {
                        const notice = Cedar.dom.closest(self, 'cedar-notice'),
                              noticeId = notice.id;

                        Cedar.classes.remove(notice, 'is-active');
                        Cedar.cookie('hide-cedar-notice__' + noticeId, true, 1);

                    }
                })
            }
        }
    };

    /*
     * Initiate listeners and the like for basic app functionality
     */
    document.addEventListener('DOMContentLoaded', function() {

        Cedar.events.on(window, 'load', function () {
            Cedar.classes.add(document.body, 'is-loaded');
        });

        Cedar.notice.init();

        Cedar.isHome = Cedar.classes.contains(document.body, 'home');

        /*
        var variationSelects = Cedar.queryAll('.variations select'),
            pos = variationSelects.length;

        while ( pos-- ) {
            if ( variationSelects[pos].value == '' ) {
                variationSelects[pos].options[1].selected = true;
            }
        }
        */


        /*
        Cedar.suggest.init({
            input: document.getElementById('woocommerce-product-search-field-0'),
            postType: 'product',
            line: true
        });

        Cedar.suggest.init({
            input: document.getElementById('billing_chs_account'),
            postType: 'account',
            match: 'post_title',
            serialize: 'postal_address',
            link: false
        });
        */
        Cedar.animationOptions();

        Cedar.events.on(window, 'resize', function(event) {
            Cedar.animationOptions();
        });

        const scrollIntervalID = setInterval(Cedar.animateStuff, 1);

        Cedar.events.on(window, 'load', function () {
			Cedar.view.enterStage();
			const viewInterval = setInterval( Cedar.view.enterStage, 10 );
		});

        /*
         * Preload marked items
         */
        Cedar.preload.init();
        Cedar.events.on(window, 'resize', function(event) {
            Cedar.preload.init();
        });

        /*
        var addToCartButtons = document.querySelectorAll('.products .product .add_to_cart_button, .course-list__children__item .cart .single_add_to_cart_button'),
            addToCartButtonsLength = addToCartButtons.length;


        while ( addToCartButtonsLength-- ) {
            if ( addToCartButtons[addToCartButtonsLength].innerHTML.toLowerCase().match(/add/)  ) {
                var plus = document.createElement('span'),
                    minus = document.createElement('span'),
                    wrap = document.createElement('span'),
                    quantity = document.createElement('span'),
                    container = document.createElement('div');

                if ( ! addToCartButtons[addToCartButtonsLength].hasAttribute('data-quantity') ) {
                    addToCartButtons[addToCartButtonsLength].setAttribute('data-quantity', 1);
                }
                addToCartButtons[addToCartButtonsLength].innerHTML = '<span class="label">Add</span>';
                quantity.className = 'quantity';
                quantity.innerHTML = addToCartButtons[addToCartButtonsLength].getAttribute('data-quantity');
                addToCartButtons[addToCartButtonsLength].appendChild(quantity);
                plus.className = 'plus';
                plus.setAttribute('data-cedar-action', 'plus-quantity');
                minus.className = 'minus';
                minus.setAttribute('data-cedar-action', 'minus-quantity');
                wrap.className = 'plus-minus';
                wrap.appendChild(plus);
                wrap.appendChild(minus);
                Cedar.classes.add(addToCartButtons[addToCartButtonsLength], 'has-plus-minus');
                container.className = 'woocommerce-loop-product__form__button';
                Cedar.dom.insertAfter(container,addToCartButtons[addToCartButtonsLength]);
                container.appendChild(addToCartButtons[addToCartButtonsLength]);
                container.appendChild(wrap);
            }

        }

        Cedar.events.on( document.body, 'click', function (event) {
            var self = event.target;
            if ( self.hasAttribute('data-cedar-action') ) {
                event.preventDefault();
                var action = self.getAttribute('data-cedar-action');
                if ( (action === 'plus-quantity' || action === 'minus-quantity') && ! Cedar.classes.contains(self, 'is-disabled') ) {
                    var button = self.parentElement.parentElement.querySelector('.add_to_cart_button') ? self.parentElement.parentElement.querySelector('.add_to_cart_button') : self.parentElement.parentElement.querySelector('.single_add_to_cart_button'),
                        quantity = Number(button.getAttribute('data-quantity')),
                        quantityNumber = button.querySelector('.quantity'),
                        form = Cedar.dom.closest(button,'cart'),
                        quantityInput = form ? form.querySelector('[name="quantity"]') : null,
                        newQuantity = ( action === 'plus-quantity' ) ? quantity + 1 : ( quantity - 1 > 0 ? quantity - 1 : 1);

                    button.setAttribute('data-quantity', newQuantity);
                    quantityNumber.innerHTML = newQuantity;

                    if ( quantityInput )
                        quantityInput.value = newQuantity;


                }
            }
        });

        Cedar.events.on(document.body, 'change', function (event) {
            var self = event.target;
            if ( self.hasAttribute('data-attribute_name') ) {
                var container = Cedar.dom.closest(self, 'product'),
                    plus = container ? container.querySelector('.plus-minus .plus') : false,
                    minus = container ? container.querySelector('.plus-minus .minus') : false;
                if ( self.value === '' ) {
                    Cedar.classes.add(plus, 'is-disabled');
                    Cedar.classes.add(minus, 'is-disabled');
                }
                else {
                    Cedar.classes.remove(plus, 'is-disabled');
                    Cedar.classes.remove(minus, 'is-disabled');
                }
            }
        })
        */
        /*
         * Custom form handlers
         */
        Cedar.events.on(document, 'submit', function (e) {

            var self = e.target;

            /*
             * Ajax add to cart from archive page
             * Necessary to get addons to work with ajax
             * May not be necessary if addons are replaced with variations
             */
            if ( Cedar.classes.contains(self, 'cart') && ( Cedar.dom.closest(self, 'products') || Cedar.dom.closest(self, 'course-list__children__item') ) ) {
                e.preventDefault();
                var formData = new FormData(self),
                    submit = self.querySelector('button[type="submit"]'),
                    addon = self.querySelector('.addon-custom-textarea');

                console.log(self.querySelector('[name="add-to-cart"]').value);
                formData.append('add-to-cart', self.querySelector('[name="add-to-cart"]').value );
                if ( addon && addon.value === '' ) {
                    addon.focus();
                    return;
                }
                submit.querySelector('.label').innerHTML = 'Adding';
                submit.disabled = true;
                Cedar.post({
                    data: formData,
                    url: self.action,
                    success: function (responseText) {
                        submit.querySelector('.label').innerHTML = 'Added';
                        setTimeout(function () {
                            submit.querySelector('.label').innerHTML = 'Add';
                        }, 2000);
                        submit.disabled = false;
                        if ( responseText.match(/"woocommerce-message"/) ) {
                            // Dispatch update_checkout event to update shipping calc
                            console.log('success');

                        }
                        else {
                            console.log('error');
                        }
                        Cedar.events.dispatch(document.body, 'wc_fragment_refresh');
                        /*var event = new UIEvent('wc_fragment_refresh', {
                            'view': window,
                            'bubbles': true,
                            'cancelable': false
                        });
                        document.body.dispatchEvent(event);*/
                    }
                })
            }
        });

        Cedar.events.on(document, 'click', function (event) {
            var self = event.target;
            if ( self.hasAttribute('data-cedar-action') && self.getAttribute('data-cedar-action') == 'toggle-expand' ) {
                var toggleable = Cedar.dom.closest(self, 'is-toggleable');
                if ( toggleable )
                    Cedar.classes.toggle(toggleable, 'is-expanded');
            }
        });

        Cedar.events.on(document, 'change', function (event) {
            var self = event.target;
            if ( self.hasAttribute('data-action') && self.getAttribute('data-action') == 'replace-select' ) {
                console.log('replace')
                var target = document.getElementById(self.getAttribute('data-action-target')),
                    jsonContent = self.options[self.selectedIndex].getAttribute('data-select-replace');

                console.log(jsonContent);
                var options = JSON.parse(jsonContent);

                target.innerHTML = '<option value="">' + target.getAttribute('data-placeholder') + '</option>';
                for ( var id in options ) {
                    target.innerHTML += '<option value="' + id + '">' + options[id] + '</option>';
                }

            }
        })


        var touchables = Cedar.queryAll('.button, button, a[href], label'),
            touchablesLength = touchables.length;

        while ( touchablesLength-- ) {
            Cedar.events.on(touchables[touchablesLength], 'touchstart', function () {});
            Cedar.events.on(touchables[touchablesLength], 'touchend', function () {});
        }

        /*
         * Bind attribure values (mostly for webinar)
         * MAY NOT NEED THIS ANYMORE
         */
        /*
        Cedar.events.on(document.body, 'change', function (event) {
            var self = event.target;

            if ( self.hasAttribute('data-attribute_name') ) {
                var container = Cedar.dom.closest(self, 'product'),
                    bound = container.querySelectorAll('[data-bind-attribute="' + self.getAttribute('data-attribute_name') + '"]'),
                    boundLength = bound.length;
                while ( boundLength-- ) {
                    bound[boundLength].innerHTML = self.value;
                }
            }
        });
        */

        /*
        var searchForm = Cedar.query('.site-header .woocommerce-product-search' ),
            searchInput = Cedar.query('.site-header .search-field');

        if ( searchForm && searchInput ) {

            Cedar.events.on(searchForm, 'click', function (event) {
                searchInput.focus();
            });
            Cedar.events.on(searchInput, 'focus', function (event) {
                Cedar.classes.add(searchForm, 'has-focus');
            });
            Cedar.events.on(searchInput, 'blur', function (event) {
                Cedar.classes.remove(searchForm, 'has-focus');
            });
        }

        Tooltip for addon text boxes

        var addons = Cedar.queryAll('.addon'),
            pos = addons.length;

        while (pos--) {
            Cedar.events.on(addons[pos], 'focus', function (event) {
                var self = event.target;
                if ( Cedar.classes.contains(self,'addon') ) {
                    var container = Cedar.dom.closest(self,'product-addon');
                    if ( container ) {
                        Cedar.classes.add(container, 'addon-focus');
                    }
                }
            });
            Cedar.events.on(addons[pos], 'blur', function (event) {
                var self = event.target;
                if ( Cedar.classes.contains(self,'addon') ) {
                    var container = Cedar.dom.closest(self,'product-addon');
                    if ( container ) {
                        Cedar.classes.remove(container, 'addon-focus');
                    }
                }
            });
        }
        */
        /*
        var catTitles = Cedar.queryAll('.woocommerce-loop-category__title'),
            pos = catTitles.length;

        while (pos--) {
            var text = catTitles[pos].innerHTML;
            if ( text.match(/\+/g) )
                Cedar.dom.closest(catTitles[pos], 'product-category').style.display = 'none';
        }
        */
        /*
         * Placeholder attr for product addons
         */
        /*var addons = Cedar.queryAll('.product-addon'),
            pos = addons.length;

        while (pos--) {
            var placeholder = addons[pos].querySelector('.addon-description p'),
                input = addons[pos].querySelector('.addon');
            if ( placeholder && input ) {
                input.placeholder = placeholder.innerText || placeholder.textContent;
            }
        }*/


        /*
         * Force external URLs to open in a new window
         */
        var links = Cedar.queryAll('[href]'),
            pos = links.length;

        while (pos--) {
            var href = links[pos].getAttribute('href');

            var domain = new RegExp(window.location.host);
            if (href.match(/http/) && !href.match(domain)) {
                links[pos].setAttribute('target', '_blank');
            }
        }


    });

})();
