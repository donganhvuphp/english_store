$(document).ready(function () {
    let translateData = {};
    let urlSubmit = '';
    let editor;
    ClassicEditor.create(document.querySelector('#editor')).then( newEditor => {
        editor = newEditor;
    }).catch( error => {
        console.log( error );
    });

    $(document).on('click', '.remove-lesson', function () {
        urlSubmit = $(this).data('url');
        $(document).find('#remove-lesson-modal').show();
    });

    $(document).on('click', '#remove-lesson-modal button', function () {
        $(document).find('#remove-lesson-modal').hide();
    });

    $(document).on('click', '#remove-lesson-modal .confirm', function () {
        console.log('urlSubmit', urlSubmit)
        $.ajax({
            url: urlSubmit,
            type: 'DELETE',
            dataType: 'json',
            success: function(response) {
                console.log('response', response)
            },
            error: function(xhr, status, error) {
            }
        });
    });

    $(document).on('click', '#translate', function () {
        const url = $(this).data('url');
        const data = {
            input: $(document).find("input[name='translate_text']").val().trim()
        }
        $.ajax({
            url,
            type: 'POST',
            dataType: 'json',
            data,
            success: function(response) {
                if (response.input && response.output) {
                    for (var i = 0; i < response.input.length; i++) {
                        if (response.input[i].trim() !== '') {
                            translateData[response.input[i].trim()] = {
                                'result': response.output[i].trim(),
                                'spelling': response.spelling[i]?.trim() || '',
                                'audio': response.audio[i]?.trim() || ''
                            }
                        }
                    }
                }
                renderData();
            },
            error: function(xhr, status, error) {
            }
        });
    });

    function renderData() {
        $(document).find('.data-translate').empty();

        if (Object.keys(translateData).length) {
            $(document).find('.translate-result').removeClass('d-none');
        } else {
            $(document).find('.translate-result').addClass('d-none');
        }

        Object.entries(translateData).reverse().map(([key, {result, spelling, audio}]) => {
            $(document).find('.data-translate').append(`
                <tr>
                    <td>${key}</td>
                    <td>${result}</td>
                    <td>${spelling}</td>
                    <td class="text-center">
                        <i class="fas fa-volume-up audio-icon cursor-pointer" data-audio="${audio}"></i>
                    </td>
                    <td class="text-center">
                        <i class="fas fa-trash text-danger delete-translate cursor-pointer" data-key="${key}"></i>
                    </td>
                </tr>
            `)
        });
    }

    $(document).on('click', '.delete-translate', function () {
        console.log(222);
        console.log(translateData);
        delete translateData[$(this).data('key')];
        renderData();
    });


    $(document).on('click', '.audio-icon', function () {
        const sound = new Audio($(this).data('audio'));
        sound.addEventListener('canplaythrough', () => {
            sound.play();
        });
    });

    $(document).on('click', '.save-translate', function (event) {
        event.preventDefault();
        let url = $(this).data('url');
        $.ajax({
            url,
            type: 'POST',
            dataType: 'json',
            data: {
                lesson: {
                    name: $(document).find("input[name='lesson']").val().trim(),
                    descriptions: editor.getData()
                },
                translate: translateData
            },
            success: function(response) {
                window.location.href = response.redirect;
            },
            error: function(xhr, status, error) {
            }
        });
    });

    $(document).on('keyup', "input[name='translate_text']", function () {
        let data = $(this).val();
        $(this).val(data.replace(/\s{2,}/g, "|"));
    });


});
