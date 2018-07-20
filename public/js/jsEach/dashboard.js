$(function(){

    var background_image;
            // var link_bg;
            if (typeof(Storage) !== "undefined") {
                // Store
                background_image = localStorage.getItem("background_image");
                link_bg = localStorage.getItem("link_bg");
                if(background_image == undefined){
                    localStorage.setItem("background_image", 'true');
                    background_image = 'true';
                }
                if(link_bg == undefined){
                    localStorage.setItem("link_bg", "{{asset('images/sidebar-5.jpg')}}");
                    link_bg = "{{asset('images/sidebar-5.jpg')}}";
                }
            }

            // console.log(link_bg);
            // console.log(localStorage.getItem('background_image'));

            //------------------------
            if(background_image == 'true'){
                var state = true;  
                $('#sidebar').append('<div class="sidebar-background" style="background-image: url(' + link_bg + ') "></div>');
            } 
            else{
                $('#sidebar').append('<div class="sidebar-background" style="background-image: url(' + link_bg + ');display:none "></div>');
                var state = false; 
            } 
            $('#sidebar').attr('data-image', link_bg);
            $sidebar_img_container = $sidebar.find('.sidebar-background');
            // -----------------------------------------------------------------
            $('.switch-image1 input').on("switchChange.bootstrapSwitch", function() {

                $input = $(this);

                if ($input.is(':checked')) {
                    $sidebar_img_container.fadeIn('fast');
                    $('#sidebar').attr('data-image', '#');
                    background_image = 'true';
                } else {
                    $('#sidebar').removeAttr('data-image');
                    $sidebar_img_container.fadeOut('fast');
                    background_image = 'false';
                }

                if (typeof(Storage) !== "undefined") {
                        // Store
                        localStorage.setItem("background_image", background_image);
                   }
            });

            $('.switch-image1 input').bootstrapSwitch('state', state);
            //---------------------------
            var sidebar_mini;

            
            if (typeof(Storage) !== "undefined") {
                // Store
                sidebar_mini = localStorage.getItem("sidebar_mini");
                // console.log(sidebar_mini);
                if(sidebar_mini == undefined){
                    localStorage.setItem("sidebar_mini", 'false');
                    sidebar_mini = 'false';
                }
            }
            if(sidebar_mini == 'true')
            {
                var state2 = true;
            }else{
                var state2 = false;
            }

            $('.switch-mini1 input').on("switchChange.bootstrapSwitch", function() {
                $body = $('body');

                if (lbd.misc.sidebar_mini_active == true) {
                    $body.removeClass('sidebar-mini');
                    lbd.misc.sidebar_mini_active = false;

                    if (isWindows) {
                        $('.sidebar .sidebar-wrapper').perfectScrollbar();
                    }
                    if (typeof(Storage) !== "undefined") {
                        // Store
                        localStorage.setItem("sidebar_mini", 'false');
                    }
                } else {

                    $('.sidebar .collapse').collapse('hide').on('hidden.bs.collapse', function() {
                        $(this).css('height', 'auto');
                    });

                    if (isWindows) {
                        $('.sidebar .sidebar-wrapper').perfectScrollbar('destroy');
                    }

                    setTimeout(function() {
                        $body.addClass('sidebar-mini');

                        $('.sidebar .collapse').css('height', 'auto');
                        lbd.misc.sidebar_mini_active = true;
                    }, 300);
                    if (typeof(Storage) !== "undefined") {
                        // Store
                        localStorage.setItem("sidebar_mini", 'true');
                    }
                }
            });

            $('.switch-mini1 input').bootstrapSwitch('state', state2);
            //-------------------------
            var navfix;
            if (typeof(Storage) !== "undefined") {
                // Store
                navfix = localStorage.getItem("navfix");
                // console.log(navfix);
                if(navfix == undefined){
                    localStorage.setItem("navfix", 'false');
                    navfix = 'false';
                }
            }
            if(navfix == 'true')
            {
                var state3 = true;
            }else{
                var state3 = false;
            }
            $('.switch-nav1 input').on("switchChange.bootstrapSwitch", function() {
                $nav = $('nav.navbar').first();

                $input = $(this);

                if($input.is(':checked')){
                    $nav.addClass('navbar-fixed');
                    navfix = 'true';
                } 
                else {
                    $nav.removeClass("navbar-fixed");
                    navfix = 'false';
                }
                if (typeof(Storage) !== "undefined") {
                    // Store
                    localStorage.setItem("navfix", navfix);
                }
            });
            // console.log(navfix);
            $('.switch-nav1 input').bootstrapSwitch('state', state3);
            //-----------------------------

            var toggleBC;
            if (typeof(Storage) !== "undefined") {
                // Store
                toggleBC = localStorage.getItem("toggleBC");
                if(toggleBC == undefined){
                    localStorage.setItem("toggleBC", "false");
                    toggleBC = 'false';
                }
            }
            // console.log(toggleBC);
            if(toggleBC == 'false')
            {
                $('#selectColor').hide();
                var state4 = false;
            }else
            {
                $('#selectColor').show();
                var state4 = true;
            }

            $('.switch-color input').on("switchChange.bootstrapSwitch", function() {
                $input = $(this);

                if($input.is(':checked')){
                    var color = localStorage.getItem('themeColor');
                    $('#selectColor').fadeIn('fast');
                    toggleBC = 'true';
                    $('#sidebar').attr('data-color', color);
                } 
                else {
                    $('#selectColor').fadeOut('fast');
                    toggleBC = 'false';
                    $('#sidebar').removeAttr('data-color');
                }
                if (typeof(Storage) !== "undefined") {
                    // Store
                    localStorage.setItem("toggleBC", toggleBC);
                }
            });
            $('.switch-color input').bootstrapSwitch('state', state4);
            //-------------------------------
            var themeColor ;

            if (typeof(Storage) !== "undefined") {
                // Store
                themeColor = localStorage.getItem("themeColor");
                if(themeColor == undefined){
                    localStorage.setItem("themeColor", "purple");
                    themeColor = 'purple';
                }
            }
            var checkColor = localStorage.getItem('toggleBC');
            if(checkColor == 'true')
            {
                $('#sidebar').attr('data-color',themeColor);
            }
            $('.fixed-plugin .background-color span[data-color='+themeColor+']').addClass('active');
            $('.fixed-plugin .background-color span').click(function() {
                $(this).siblings().removeClass('active');
                $(this).addClass('active');

                var themeColor = $(this).data('color');
                $('#sidebar').attr('data-color',themeColor);
                    if (typeof(Storage) !== "undefined") {
                        // Store
                        localStorage.setItem("themeColor", themeColor);
                   }
            });
            //--------------------------------------------------------
            // console.log(link_bg);
            $('.fixed-plugin .img-holder img[src="'+ link_bg +'"]').parents('li').addClass('active');
            $('.fixed-plugin .img-holder').click(function() {
                $full_page_background = $('.full-page-background');

                $(this).parent('li').siblings().removeClass('active');
                $(this).parent('li').addClass('active');

                var new_image = $(this).find("img").attr('src');
                if ($sidebar_img_container.length != 0 && $('.switch-image1 input:checked').length != 0) {
                    $sidebar_img_container.fadeOut('fast', function() {
                        $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                        $sidebar_img_container.fadeIn('fast');
                    });
                }

                if ($('.switch-image1 input:checked').length == 0) {
                    var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                    var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                    $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                    $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                }

                if ($sidebar_responsive.length != 0) {
                    $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                }            
                link_bg = new_image;
                if (typeof(Storage) !== "undefined") {
                        // Store
                        localStorage.setItem("link_bg", link_bg);
                   }
            });
});
