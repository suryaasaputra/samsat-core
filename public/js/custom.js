var Zenix = (function () {
    "use strict";

    /* Search Bar ============ */
    var screenWidth = $(window).width();

    var handleSelectPicker = function () {
        if (jQuery(".default-select").length > 0) {
            jQuery(".default-select").selectpicker();
        }
    };

    var handleTheme = function () {
        $("#preloader").fadeOut(500);
        $("#main-wrapper").addClass("show");
    };

    var handleMetisMenu = function () {
        if (jQuery("#menu").length > 0) {
            $("#menu").metisMenu();
        }
        jQuery(".metismenu > .mm-active ").each(function () {
            if (!jQuery(this).children("ul").length > 0) {
                jQuery(this).addClass("active-no-child");
            }
        });
    };
    var handleCkEditor = function () {
        if (jQuery("#ckeditor").length > 0) {
            ClassicEditor.create(document.querySelector("#ckeditor"), {
                // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
            })
                .then((editor) => {
                    window.editor = editor;
                })
                .catch((err) => {
                    console.error(err.stack);
                });
        }
    };
    var domoPanel = function () {
        const ps = new PerfectScrollbar(".dz-demo-content");
        $(".dz-demo-trigger").on("click", function () {
            $(".dz-demo-panel").addClass("show");
        });
        $(".dz-demo-close, .bg-close,.dz_theme_demo,.dz_theme_demo_rtl").on(
            "click",
            function () {
                $(".dz-demo-panel").removeClass("show");
            }
        );

        $(".dz-demo-bx").on("click", function () {
            $(".dz-demo-bx").removeClass("demo-active");
            $(this).addClass("demo-active");
        });
    };

    var handleAllChecked = function () {
        $("#checkAll").on("change", function () {
            $(
                "td input:checkbox, .email-list .custom-checkbox input:checkbox"
            ).prop("checked", $(this).prop("checked"));
        });
    };

    var handleNavigation = function () {
        $(".nav-control").on("click", function () {
            $("#main-wrapper").toggleClass("menu-toggle");

            $(".hamburger").toggleClass("is-active");
        });
    };

    var handleCurrentActive = function () {
        for (
            var nk = window.location,
                o = $("ul#menu a")
                    .filter(function () {
                        return this.href == nk;
                    })
                    .addClass("mm-active")
                    .parent()
                    .addClass("mm-active");
            ;

        ) {
            if (!o.is("li")) break;

            o = o.parent().addClass("mm-show").parent().addClass("mm-active");
        }
    };

    var handleMiniSidebar = function () {
        $("ul#menu>li").on("click", function () {
            const sidebarStyle = $("body").attr("data-sidebar-style");
            if (sidebarStyle === "mini") {
                console.log($(this).find("ul"));
                $(this).find("ul").stop();
            }
        });
    };

    var handleMinHeight = function () {
        var win_h = window.outerHeight;
        var win_h = window.outerHeight;
        if (win_h > 0 ? win_h : screen.height) {
            $(".content-body").css("min-height", win_h + 60 + "px");
        }
    };

    var handleDataAction = function () {
        $('a[data-action="collapse"]').on("click", function (i) {
            i.preventDefault(),
                $(this)
                    .closest(".card")
                    .find('[data-action="collapse"] i')
                    .toggleClass("mdi-arrow-down mdi-arrow-up"),
                $(this)
                    .closest(".card")
                    .children(".card-body")
                    .collapse("toggle");
        });

        $('a[data-action="expand"]').on("click", function (i) {
            i.preventDefault(),
                $(this)
                    .closest(".card")
                    .find('[data-action="expand"] i')
                    .toggleClass("icon-size-actual icon-size-fullscreen"),
                $(this).closest(".card").toggleClass("card-fullscreen");
        });

        $('[data-action="close"]').on("click", function () {
            $(this).closest(".card").removeClass().slideUp("fast");
        });

        $('[data-action="reload"]').on("click", function () {
            var e = $(this);
            e.parents(".card").addClass("card-load"),
                e
                    .parents(".card")
                    .append(
                        '<div class="card-loader"><i class=" ti-reload rotate-refresh"></div>'
                    ),
                setTimeout(function () {
                    e.parents(".card").children(".card-loader").remove(),
                        e.parents(".card").removeClass("card-load");
                }, 2000);
        });
    };

    var handleHeaderHight = function () {
        const headerHight = $(".header").innerHeight();
        $(window).scroll(function () {
            if (
                $("body").attr("data-layout") === "horizontal" &&
                $("body").attr("data-header-position") === "static" &&
                $("body").attr("data-sidebar-position") === "fixed"
            )
                $(this.window).scrollTop() >= headerHight
                    ? $(".deznav").addClass("fixed")
                    : $(".deznav").removeClass("fixed");
        });
    };

    var handleDzScroll = function () {
        jQuery(".dz-scroll").each(function () {
            var scroolWidgetId = jQuery(this).attr("id");
            const ps = new PerfectScrollbar("#" + scroolWidgetId, {
                wheelSpeed: 2,
                wheelPropagation: true,
                minScrollbarLength: 20,
            });
            ps.isRtl = false;
        });
    };

    var handleMenuTabs = function () {
        if (screenWidth <= 991) {
            jQuery(".menu-tabs .nav-link").on("click", function () {
                if (jQuery(this).hasClass("open")) {
                    jQuery(this).removeClass("open");
                    jQuery(".fixed-content-box").removeClass("active");
                    jQuery(".hamburger").show();
                } else {
                    jQuery(".menu-tabs .nav-link").removeClass("open");
                    jQuery(this).addClass("open");
                    jQuery(".fixed-content-box").addClass("active");
                    jQuery(".hamburger").hide();
                }
                //jQuery('.fixed-content-box').toggleClass('active');
            });
            jQuery(".close-fixed-content").on("click", function () {
                jQuery(".fixed-content-box").removeClass("active");
                jQuery(".hamburger").removeClass("is-active");
                jQuery("#main-wrapper").removeClass("menu-toggle");
                jQuery(".hamburger").show();
            });
        }
    };

    var handleChatbox = function () {
        jQuery(".bell-link").on("click", function () {
            jQuery(".chatbox").addClass("active");
        });
        jQuery(".chatbox-close").on("click", function () {
            jQuery(".chatbox").removeClass("active");
        });
    };

    var handlePerfectScrollbar = function () {
        if (jQuery(".deznav-scroll").length > 0) {
            //const qs = new PerfectScrollbar('.deznav-scroll');
            const qs = new PerfectScrollbar(".deznav-scroll");

            qs.isRtl = false;
        }
    };

    var handleBtnNumber = function () {
        $(".btn-number").on("click", function (e) {
            e.preventDefault();

            fieldName = $(this).attr("data-field");
            type = $(this).attr("data-type");
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val(), 10);
            if (!isNaN(currentVal)) {
                if (type == "minus") input.val(currentVal - 1);
                else if (type == "plus") input.val(currentVal + 1);
            } else {
                input.val(0);
            }
        });
    };

    var handleDzChatUser = function () {
        jQuery(".dz-chat-user-box .dz-chat-user").on("click", function () {
            jQuery(".dz-chat-user-box").addClass("d-none");
            jQuery(".dz-chat-history-box").removeClass("d-none");
        });

        jQuery(".dz-chat-history-back").on("click", function () {
            jQuery(".dz-chat-user-box").removeClass("d-none");
            jQuery(".dz-chat-history-box").addClass("d-none");
        });

        jQuery(".dz-fullscreen").on("click", function () {
            jQuery(".dz-fullscreen").toggleClass("active");
        });
    };

    var handleDzFullScreen = function () {
        jQuery(".dz-fullscreen").on("click", function (e) {
            if (
                document.fullscreenElement ||
                document.webkitFullscreenElement ||
                document.mozFullScreenElement ||
                document.msFullscreenElement
            ) {
                /* Enter fullscreen */
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen(); /* IE/Edge */
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen(); /* Firefox */
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen(); /* Chrome, Safari & Opera */
                }
            } else {
                /* exit fullscreen */
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.msRequestFullscreen) {
                    document.documentElement.msRequestFullscreen();
                }
            }
        });
    };

    var handleshowPass = function () {
        jQuery(".show-pass").on("click", function () {
            jQuery(this).toggleClass("active");
            if (jQuery("#dz-password").attr("type") == "password") {
                jQuery("#dz-password").attr("type", "text");
            } else if (jQuery("#dz-password").attr("type") == "text") {
                jQuery("#dz-password").attr("type", "password");
            }
        });
    };

    var heartBlast = function () {
        $(".heart").on("click", function () {
            $(this).toggleClass("heart-blast");
        });
    };

    var handleDzLoadMore = function () {
        $(".dz-load-more").on("click", function (e) {
            e.preventDefault(); //STOP default action
            $(this).append(' <i class="fa fa-refresh"></i>');

            var dzLoadMoreUrl = $(this).attr("rel");
            var dzLoadMoreId = $(this).attr("id");

            $.ajax({
                method: "POST",
                url: dzLoadMoreUrl,
                dataType: "html",
                success: function (data) {
                    $("#" + dzLoadMoreId + "Content").append(data);
                    $(".dz-load-more i").remove();
                },
            });
        });
    };

    var handleLightgallery = function () {
        if (jQuery("#lightgallery").length > 0) {
            $("#lightgallery").lightGallery({
                loop: true,
                thumbnail: true,
                exThumbImage: "data-exthumbimage",
            });
        }
    };

    var handleSmartWizard = function () {
        if (jQuery("#smartwizard").length > 0) {
            $(document).ready(function () {
                // SmartWizard initialize
                $("#smartwizard").smartWizard();
            });
        }
    };
    var handleCustomFileInput = function () {
        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this)
                .siblings(".custom-file-label")
                .addClass("selected")
                .html(fileName);
        });
    };

    var vHeight = function () {
        var ch = $(window).height() - 206;
        $(".chatbox .msg_card_body").css("height", ch);
    };

    var handleChatSidebar = function () {
        $(".chat-hamburger").on("click", function () {
            $(".chat-left-sidebar").toggleClass("show");
        });
    };

    var handleMenuPosition = function () {
        if (screenWidth > 1024) {
            $(".metismenu  li")
                .unbind()
                .each(function (e) {
                    if ($("ul", this).length > 0) {
                        var elm = $("ul:first", this).css("display", "block");

                        var off = elm.offset();
                        var l = off.left;
                        var w = elm.width();
                        var elm = $("ul:first", this).removeAttr("style");
                        var docH = $("body").height();
                        var docW = $("body").width();

                        if (jQuery("html").hasClass("rtl")) {
                            var isEntirelyVisible = l + w <= docW;
                        } else {
                            var isEntirelyVisible = l > 0 ? true : false;
                        }

                        if (!isEntirelyVisible) {
                            $(this).find("ul:first").addClass("left");
                        } else {
                            $(this).find("ul:first").removeClass("left");
                        }
                    }
                });
        }
    };

    var handleImageSelect = function () {
        const $_SELECT_PICKER = $(".image-select");
        $_SELECT_PICKER.find("option").each((idx, elem) => {
            const $OPTION = $(elem);
            const IMAGE_URL = $OPTION.attr("data-thumbnail");
            if (IMAGE_URL) {
                $OPTION.attr(
                    "data-content",
                    "<img src='%i'/> %s"
                        .replace(/%i/, IMAGE_URL)
                        .replace(/%s/, $OPTION.text())
                );
            }
            console.warn("option:", idx, $OPTION);
        });
        $_SELECT_PICKER.selectpicker();
    };
    var handleThemeMode = function () {
        jQuery(".dz-theme-mode").on("click", function () {
            jQuery(this).toggleClass("active");

            if (jQuery(this).hasClass("active")) {
                jQuery("body").attr("data-theme-version", "dark");
            } else {
                jQuery("body").attr("data-theme-version", "light");
            }
        });
    };

    /* Function ============ */
    return {
        init: function () {
            handleTheme();
            handleMetisMenu();
            handleAllChecked();
            handleNavigation();
            handleCurrentActive();
            handleMiniSidebar();
            handleMinHeight();
            handleDataAction();
            handleHeaderHight();
            handleDzScroll();
            handleMenuTabs();
            handleChatbox();
            handlePerfectScrollbar();
            handleBtnNumber();
            handleDzChatUser();
            handleDzFullScreen();
            handleshowPass();
            heartBlast();
            handleDzLoadMore();
            handleLightgallery();
            handleSmartWizard();
            handleCustomFileInput();
            vHeight();
            handleChatSidebar();
            handleCkEditor();
            handleImageSelect();
            handleThemeMode();
            domoPanel();
        },

        load: function () {
            handleTheme();
            handleSelectPicker();
            handleImageSelect();
        },

        resize: function () {
            vHeight();
        },

        handleMenuPosition: function () {
            handleMenuPosition();
        },
    };
})();

/* Document.ready Start */
jQuery(document).ready(function () {
    $('[data-toggle="popover"]').popover();
    ("use strict");
    Zenix.init();
    var popoverTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="popover"]')
    );
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
});
/* Document.ready END */

/* Window Load START */
jQuery(window).on("load", function () {
    "use strict";
    Zenix.load();
    setTimeout(function () {
        Zenix.handleMenuPosition();
    }, 1000);
});
/*  Window Load END */
/* Window Resize START */
jQuery(window).on("resize", function () {
    "use strict";
    Zenix.resize();
    setTimeout(function () {
        Zenix.handleMenuPosition();
    }, 1000);
});
/*  Window Resize END */
