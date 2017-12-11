var galleryPopup = null;
var galleryMedias = [];
var galleryCurrentMedia = 0;

function galleryMediasAdded()
{
    var submitButton = document.getElementById("submit");
    submitButton.click();
    return true;
}

$(document).ready(function() {
    $(".widget-gallery .gallery-media").on("click", galleryShowPopup);
});

function galleryShowPopup(event)
{
    var media = event.currentTarget;

    galleryCurrentMedia = $(media).data("index");

    var $gallery = $(media).parents(".widget-gallery");
    galleryMedias = [];
    $gallery.find(".gallery-media").each(function(index, element) {
        var data = JSON.parse(decodeURIComponent($(element).data("media")));
        galleryMedias.push(data);
    });

    params = {
        postData: null,
        id: "gallery_popup",
        title: "",
        url: "",
        actions: {
            load: galleryPopupLoadEvent.bind(this)
        }
    };

    if (galleryPopup != null) {
        galleryPopup.close();
    }

    galleryPopup = new LazyDialog();
    galleryPopup.open(params);
}

function galleryPopupResizeEvent(event)
{
    var maxWidth = $("#gallery_popup .lazy-dialog-body").width();

    var maxHeight =
        $("#gallery_popup .lazy-dialog-body").height()/* -
        $("#gallery_popup .gallery-popup-media-title").outerHeight() -
        $("#gallery_popup .gallery-popup-media-description").outerHeight()*/;

    $("#gallery_popup .gallery-popup-media").outerWidth(maxWidth);
    $("#gallery_popup .gallery-popup-media").outerHeight(maxHeight);
}

function galleryPopupLoadEvent(event)
{
    $(window).on("resize", galleryPopupResizeEvent);

    var active = "";
    var orientation = "";
    var html = "";
    var i = 0;

    for (i = 0; i < galleryMedias.length; i = i + 1) {
        active = i == galleryCurrentMedia ? " active" : "";

        if (galleryMedias[i].imageInfos.width > galleryMedias[i].imageInfos.height) {
            orientation = " landscape";
        } else {
            orientation = " portrait";
        }

        html = html +
            '<div class="gallery-popup-media'+active+'" data-index="'+i+'">' +
                '<img class="gallery-popup-media-image'+orientation+'" src="' + galleryMedias[i].image + '" alt="" />' +
                // '<div class="gallery-popup-media-title">'+galleryMedias[i].title+'</div>' +
                // '<div class="gallery-popup-media-description">'+galleryMedias[i].description+'</div>' +
            '</div>';
    }

    html = html + '<div class="gallery-popup-arrow gallery-popup-arrow-prev"><i class="fa fa-arrow-left"></i></div>';
    html = html + '<div class="gallery-popup-arrow gallery-popup-arrow-next"><i class="fa fa-arrow-right"></i></div>';

    var body = $("#gallery_popup .lazy-dialog-body")[0];
    body.innerHTML = html;

    $("#gallery_popup .gallery-popup-arrow").on("click", galleryPopupChangeMedia);

    galleryPopupResizeEvent(null);
}

function galleryPopupChangeMedia(event)
{
    var arrow = event.currentTarget;

    if ($(arrow).hasClass("gallery-popup-arrow-next")) {
        galleryCurrentMedia = galleryCurrentMedia + 1;
    } else {
        galleryCurrentMedia = galleryCurrentMedia - 1;
    }

    if (galleryCurrentMedia < 0) {
        galleryCurrentMedia = galleryMedias.length - 1;
    } else if (galleryCurrentMedia >= galleryMedias.length) {
        galleryCurrentMedia = 0;
    }

    $("#gallery_popup .gallery-popup-media").removeClass("active");
    $("#gallery_popup .gallery-popup-media[data-index="+galleryCurrentMedia+"]").addClass("active");
}
