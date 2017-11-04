// Вид из окна
function initWindowsView(floor, windows) {
  var floorNumber = floor;
  var windowsView = windows;
  if($('#FloorView').length) {

    var openWindowView = function() {
       var pswpElement = document.querySelectorAll('.pswp')[0];

       var slides = windowsView.split(', ');


       // build items array
       var items = [];

       for (key in slides) {
         if (slides[key] === 'юг') {
           slides[key] = '01';
         } else if (slides[key] === 'восток') {
           slides[key] = '02';
         } else if (slides[key] === 'север') {
           slides[key] = '03';
         } else if (slides[key] === 'запад') {
           slides[key] = '04';
         }
         items.push({
           src: '/public/image/gallery/floors/' + floorNumber + '/' + slides[key] + '.jpg',
           w: 1280,
           h: 720
         })
       }


       // define options (if needed)
       var options = {
          // history & focus options are disabled on CodePen
          history: false,
          focus: false,

          showAnimationDuration: 0,

          shareEl: false,

          preloaderEl: true,
       };

       var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
       gallery.init();
   };



   document.getElementById('FloorView').onclick = openWindowView;
  };
}

$(document).ready(function() {

// Select
  $(".js-example-basic-multiple").select2({});
// Select

// Галерея
if($("#GalleryRun").length) {
 var openPhotoSwipe = function() {
    var pswpElement = document.querySelectorAll('.pswp')[0];

    // build items array
    var items = [
        {
            src: '/public/image/gallery/01.jpg',
            w: 1280,
            h: 720
    },
        {
            src: '/public/image/gallery/02.jpg',
            w: 1280,
            h: 720
        }
    ];

    // define options (if needed)
    var options = {
             // history & focus options are disabled on CodePen
        history: false,
        focus: false,

        showAnimationDuration: 0,

        shareEl: false,

preloaderEl: true,

    };

    var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
    gallery.init();
};



document.getElementById('GalleryRun').onclick = openPhotoSwipe;
};




});
