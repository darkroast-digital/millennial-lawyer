// *************************************************************************
// *************************************************************************
// *************************************************************************

require('./bootstrap');



// #ACCODION
// =========================================================================

$('.accordion__content').hide();
$('.accordion__content').first().show();
$('.accordion__panel').first().addClass('is--open');

$('.accordion__title').click(function() {
    $('.accordion__panel').removeClass('is--open');
    $(this).parent().addClass('is--open');
    $('.accordion__content').slideUp(200);
    $(this).next('.accordion__content').slideDown(200);
});



// #TABS
// =========================================================================

$('li[data-tab], .tabs__content').first().addClass('is--active');
$('.tabs__content').first().addClass('is--active');

$('li[data-tab]').click(function() {
    var thisTab = $(this).attr('data-tab');
    var tab = $('.tabs__content' + '[data-tab="' + thisTab + '"]');

    $('li[data-tab]').removeClass('is--active');
    $(this).addClass('is--active');
    $('.tabs__content').removeClass('is--active');
    tab.addClass('is--active');
});




// #DROPDOWN
// =========================================================================

$('.dropdown__container').mouseenter(function() {
    $(this).addClass('is--active');
});

$('.dropdown__container').mouseleave(function() {
    $(this).removeClass('is--active');
});

$('.dropdown').mouseleave(function() {
    $(this).parent().removeClass('is--active');
});




// #ALERT NOTIFY
// =========================================================================

$('.alert--notify').click(function() {
    $(this).fadeOut(200);
});



// #OFF CANVAS
// =========================================================================

var offCanvasTrigger = document.querySelector('.off-canvas__trigger');
var offCanvas = document.querySelector('.off-canvas');

if (offCanvasTrigger) {
    offCanvasTrigger.addEventListener('click', function () {
        offCanvas.classList.add('is--open');
        overlay.classList.add('is--active');
    });
}




// #ADMIN OFF CANVAS
// =========================================================================

var adminOffCanvasTrigger = document.querySelector('.admin-off-canvas__trigger');
var adminOffCanvas = document.querySelector('.admin-off-canvas');

if (adminOffCanvasTrigger) {
    adminOffCanvasTrigger.addEventListener('click', function () {
        adminOffCanvas.classList.add('is--open');
        overlay.classList.add('is--active');
    });
}



// #ABOUT MODAL
// =========================================================================

var aboutModalTrigger = document.querySelector('.about-modal__trigger');
var aboutModal = document.querySelector('.about-modal');
var body = document.querySelector('body');

if (aboutModalTrigger) {
    aboutModalTrigger.addEventListener('click', function () {
        aboutModal.classList.add('is--open');
        overlay.classList.add('is--active');
        body.style.overflow = "hidden";
    });
}

// #SUBSCRIBE MODAL
// =========================================================================

var subModalTrigger = document.querySelectorAll('.subscribe-modal__trigger');
var subModal = document.querySelector('.subscribe-modal');
var body = document.querySelector('body');

if (subModalTrigger) {
    subModalTrigger.forEach(item => {
        item.addEventListener('click', function () {
            subModal.classList.add('is--open');
            overlay.classList.add('is--active');
            body.style.overflow = "hidden";
        });
    });
}



// #KEY CONTROL
// =========================================================================

$(document).keyup(function(e) {
    if (e.keyCode === 27) {
        overlay.classList.remove('is--active');
    }
});

if (offCanvas) {

    $(document).keyup(function(e) {
        if (e.keyCode === 27) {
            offCanvas.classList.remove('is--open');
        }
    });

}

if (adminOffCanvas) {

    $(document).keyup(function(e) {
        if (e.keyCode === 27) {
            adminOffCanvas.classList.remove('is--open');
        }
    });

}

if (aboutModal) {

    $(document).keyup(function(e) {
        if (e.keyCode === 27) {
            aboutModal.classList.remove('is--open');
            body.style.overflowY = "scroll";
        }
    });

}

if (subModal) {

    $(document).keyup(function (e) {
        if (e.keyCode === 27) {
            subModal.classList.remove('is--open');
            body.style.overflowY = "scroll";
        }
    });

}



// #OVERLAY
// =========================================================================

var overlay = document.querySelector('.overlay');

if (overlay) {
    overlay.addEventListener('click', function () {
        this.classList.remove('is--active');
    });
}

if (overlay) {
    overlay.addEventListener('click', function () {
        offCanvas.classList.remove('is--open');
    });
}

if (overlay) {
    overlay.addEventListener('click', function () {
        adminOffCanvas.classList.remove('is--open');
    });
}

if (overlay) {
    overlay.addEventListener('click', function () {
        subModal.classList.remove('is--open');
        body.style.overflowY = "scroll";
    });
}

if (overlay) {
    overlay.addEventListener('click', function () {
        aboutModal.classList.remove('is--open');
        body.style.overflowY = "scroll";
    });
}



// #EMAIL FORM
// =========================================================================

var form = $('.form');

$(form).submit(function(e) {
  e.preventDefault();

  var formData = new FormData($(this)[0]);

  //if files => formData.append('file', $('input[type=file]')[0].files[0]);

  $.ajax({
    type: 'post',
    url: $(this).attr('action'),
    data: formData,
    processData: false,
    contentType: false
  })
  .done(function (response) {
    $('input').val('');
    $('textarea').val('');
    $('<div class="alert is-success">Your Message Was Sent! We\'ll be in touch.</div>').insertAfter(form);
    
    console.log('success' + response);
  })
  .fail(function (data) {
    $('input').val('');
    $('textarea').val('');
    $('<div class="alert is-error">Oh no! Something went wrong, try again.</div>').insertAfter(form);
    
    console.log('fail' + data);
  })

});




// #SMOOTH SCROLL
// =========================================================================

$('a[href^="#"]').on('click', function(event) {
    var target = $(this.getAttribute('href'));
    if( target.length ) {
        event.preventDefault();
        $('html, body').stop().animate({
            scrollTop: target.offset().top
        }, 1000);
    }
});




// #ALERT FADE OUT
// =========================================================================

$('.alert').delay(6000).fadeOut("slow");




// #VIEW PASSWORD
// =========================================================================

var viewPassword = document.getElementsByClassName('view-password');

if (viewPassword) {
    for (i = 0; i < viewPassword.length; i++){
        viewPassword[i].addEventListener('click', function() {
            passwordInput = this.previousElementSibling;
            if (this.classList.contains('is-active')) {
                this.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <g class="nc-icon-wrapper" fill="#A9BFD6">
            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"></path>
        </g>
    </svg>`;
                this.classList.remove('is-active');
                passwordInput.setAttribute('type', 'password');
            } else {
                this.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <g class="nc-icon-wrapper" fill="#A9BFD6">
            <path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"></path>
        </g>
    </svg>`;
                this.classList.add('is-active');
                passwordInput.setAttribute('type', 'text');
            }
        });
    }
}




// #IMAGE PREVIEW
// =========================================================================

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('.image-preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$('.image-upload input').change(function() {
    $(this).parent().find('span').hide();
    readURL(this);
    $('.image-preview').show();
})




// #SIMPLE MDE
// =========================================================================

var mde = document.getElementById('mde')

if (mde) {
    var simplemde = new SimpleMDE({ 
        element: mde,
        hideIcons: [
            'fullscreen',
            'side-by-side'
        ]
    });
}




// #FILE UPLOAD
// =========================================================================

var fileUpload = document.getElementById('files');
var fileLabel = document.querySelector('label.files span');
var filePreview = document.querySelector('.file-preview');

var pdfIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
    <g class="nc-icon-wrapper" fill="#f82044">
        <path d="M20 2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8.5 7.5c0 .83-.67 1.5-1.5 1.5H9v2H7.5V7H10c.83 0 1.5.67 1.5 1.5v1zm5 2c0 .83-.67 1.5-1.5 1.5h-2.5V7H15c.83 0 1.5.67 1.5 1.5v3zm4-3H19v1h1.5V11H19v2h-1.5V7h3v1.5zM9 9.5h1v-1H9v1zM4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm10 5.5h1v-3h-1v3z"></path>
    </g>
</svg>`;

var imageIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
    <g class="nc-icon-wrapper" fill="#05c68c">
        <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"></path>
    </g>
</svg>`;

var fileIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
    <g class="nc-icon-wrapper" fill="#0daec3">
        <path d="M6 2c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6H6zm7 7V3.5L18.5 9H13z"></path>
    </g>
</svg>`;

function formatBytes(bytes, decimals) {
    if (bytes == 0) {
        return '0 Bytes';
    }

    var k = 1024,
        dm = decimals || 2,
        sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
        int = Math.floor(Math.log(bytes) / Math.log(k));

        return parseFloat((bytes / Math.pow(k, int)).toFixed(dm)) + ' ' + sizes[int];
}

if (fileUpload) {

    fileUpload.addEventListener('change', function() {

        if ('files' in fileUpload) {

            fileLabel.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
    <g class="nc-icon-wrapper" fill="#acc1d5">
        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path>
    </g>
</svg> Files Uploaded!`;

            for(var i = 0; i < fileUpload.files.length; i++){
                var file = fileUpload.files[i];

                if ('name' in file) {
                    var extension = file.name.split('.').pop();
                    var size = formatBytes(file.size)

                    if (extension == 'pdf') {
                        filePreview.innerHTML += `<li>${pdfIcon}<p><strong>${file.name}</strong><br>${size}<p></li>`
                    } else if (extension == 'jpg' || extension == 'png' || extension == 'gif') {
                        filePreview.innerHTML += `<li>${imageIcon}<p><strong>${file.name}</strong><br>${size}<p></li>`
                    } else {
                        filePreview.innerHTML += `<li>${fileIcon}<p><strong>${file.name}</strong><br>${size}<p></li>`
                    }
                }
            }
        }
    });

}




// #TITLE AND SLUG UPDATE
// =========================================================================

$('#title').keyup(function() {
    $('#slug').val($('#title').val().replace(/\s+/g, '-').toLowerCase());
    $('#ogtitle').val($('#title').val());
});




// #BACK BUTTON
// =========================================================================

$('.go-back').on('click', function() {
    window.history.back();
});
