<?php if ($pageRequest && $pageRequest == 'home') { ?>
<script type="text/javascript">
    var questions = JSON.parse('<?=json_encode($questions)?>');
    $(document).ready(function() {
        $('#bs_datepicker_range_container').datepicker({
            autoclose: true,
            container: '#bs_datepicker_range_container',
            language: 'tr'
        });
        $.ajax({
            url: "access-logs",
            type: "POST",
            contentType: false,
            cache: false,
            processData:false,
            headers : {
                'csrftoken': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data)
            {
                $(".accessLogs").html(data);
            }
        });
        $.ajax({
            url: "poll-answers",
            type: "POST",
            contentType: false,
            cache: false,
            processData:false,
            headers : {
                'csrftoken': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data)
            {
                $(".pollAnswers").html(data);
            }
        });
        $(document).on("click", '.paginateButton', function(event) {
            event.preventDefault();
            var page = this.id;
            var sort = $("select#sort").val();
            var regexpNumeric = /[^0-9]/g;
            var regexpAlphaNumeric = /[^a-z0-9]/g;
            var filter = $("input[name='filter']:checked").attr("id");
            $.ajax({
                url: "access-logs?page="+page.replace(regexpNumeric,'')+"&sort="+sort.replace(regexpNumeric,'')+"&filter="+filter.replace(regexpAlphaNumeric,''),
                type: "POST",
                contentType: false,
                cache: false,
                processData:false,
                headers : {
                    'csrftoken': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function()
                {
                    $('.page-loader-wrapper').fadeIn(100);
                },
                success: function(data)
                {
                    $(".accessLogs").html(data);
                    $('.page-loader-wrapper').fadeOut();
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                }
            });
        });
        $(document).on("click", '.paginateButtonPoll', function(event) {
            event.preventDefault();
            var page = this.id;
            var sort = $("select#sortPoll").val();
            var regexpNumeric = /[^0-9]/g;
            var regexpNumericWithDot = /[^0-9.]/g;
            var startDate = $("#startDate").val();
            var endDate = $("#endDate").val();
            $.ajax({
                url: "poll-answers?page="+page.replace(regexpNumeric,'')+"&sort="+sort.replace(regexpNumeric,'')+"&startDate="+startDate.replace(regexpNumericWithDot,'')+"&endDate="+endDate.replace(regexpNumericWithDot,''),
                type: "POST",
                contentType: false,
                cache: false,
                processData:false,
                headers : {
                    'csrftoken': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function()
                {
                    $('.page-loader-wrapper').fadeIn(100);
                },
                success: function(data)
                {
                    $(".pollAnswers").html(data);
                    $('.page-loader-wrapper').fadeOut();
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                }
            });
        });
        $(document).on("change", 'select#sort', function(event) {
            event.preventDefault();
            var sort = $("select#sort").val();
            var regexpNumeric = /[^0-9]/g;
            var regexpAlphaNumeric = /[^a-z0-9]/g;
            var filter = $("input[name='filter']:checked").attr("id");
            $.ajax({
                url: "access-logs?sort="+sort.replace(regexpNumeric,'')+"&filter="+filter.replace(regexpAlphaNumeric,''),
                type: "POST",
                contentType: false,
                cache: false,
                processData:false,
                headers : {
                    'csrftoken': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function()
                {
                    $('.page-loader-wrapper').fadeIn(100);
                },
                success: function(data)
                {
                    $(".accessLogs").html(data);
                    $('.page-loader-wrapper').fadeOut();
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                }
            });
        });
        $(document).on("change", 'select#sortPoll', function(event) {
            event.preventDefault();
            var sort = $("select#sortPoll").val();
            var regexpNumeric = /[^0-9]/g;
            var regexpNumericWithDot = /[^0-9.]/g;
            var startDate = $("#startDate").val();
            var endDate = $("#endDate").val();
            $.ajax({
                url: "poll-answers?sort="+sort.replace(regexpNumeric,'')+"&startDate="+startDate.replace(regexpNumericWithDot,'')+"&endDate="+endDate.replace(regexpNumericWithDot,''),
                type: "POST",
                contentType: false,
                cache: false,
                processData:false,
                headers : {
                    'csrftoken': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function()
                {
                    $('.page-loader-wrapper').fadeIn(100);
                },
                success: function(data)
                {
                    $(".pollAnswers").html(data);
                    $('.page-loader-wrapper').fadeOut();
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                }
            });
        });
        $(document).on("change", '#startDate', function(event) {
            event.preventDefault();
            var sort = $("select#sortPoll").val();
            var regexpNumeric = /[^0-9]/g;
            var regexpNumericWithDot = /[^0-9.]/g;
            var startDate = $("#startDate").val();
            var endDate = $("#endDate").val();
            $.ajax({
                url: "poll-answers?sort="+sort.replace(regexpNumeric,'')+"&startDate="+startDate.replace(regexpNumericWithDot,'')+"&endDate="+endDate.replace(regexpNumericWithDot,''),
                type: "POST",
                contentType: false,
                cache: false,
                processData:false,
                headers : {
                    'csrftoken': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function()
                {
                    $('.page-loader-wrapper').fadeIn(100);
                },
                success: function(data)
                {
                    $(".pollAnswers").html(data);
                    $('.page-loader-wrapper').fadeOut();
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                }
            });
        });
        $(document).on("change", '#endDate', function(event) {
            event.preventDefault();
            var sort = $("select#sortPoll").val();
            var regexpNumeric = /[^0-9]/g;
            var regexpNumericWithDot = /[^0-9.]/g;
            var startDate = $("#startDate").val();
            var endDate = $("#endDate").val();
            $.ajax({
                url: "poll-answers?sort="+sort.replace(regexpNumeric,'')+"&startDate="+startDate.replace(regexpNumericWithDot,'')+"&endDate="+endDate.replace(regexpNumericWithDot,''),
                type: "POST",
                contentType: false,
                cache: false,
                processData:false,
                headers : {
                    'csrftoken': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function()
                {
                    $('.page-loader-wrapper').fadeIn(100);
                },
                success: function(data)
                {
                    $(".pollAnswers").html(data);
                    $('.page-loader-wrapper').fadeOut();
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                }
            });
        });
        $(document).on("click", '#clearFilter', function(event) {
           event.preventDefault();
            $("#startDate").val('');
            $("#endDate").val('').trigger('change');
            $('#bs_datepicker_range_container').datepicker('clearDates');
        });
        $(document).on("click", '.showAnswersButton', function() {
            var answers = $(this).data('answers');
            var language = $(this).data('language');
            let answersContent = '';
            if (answers) {
                answersContent += '<div class="list-group">';
                answers.split('|||').forEach(function(item, index) {
                    if (questions[index + 1]['type'] === 'starring') {
                        answersContent += '<span class="list-group-item"><h4 class="list-group-item-heading">' + questions[index + 1]['question'][language] + '</h4>';
                        let i = 0;
                        for (var subOption in questions[index + 1]['options'][language]) {
                            answersContent += '<p class="list-group-item-text"><strong>' + subOption + ': </strong>' + (item.split(',')[i] && item.split(',')[i] !== '' ? (item.split(',')[i] + ' ' + (language === 'tr' ? 'Yıldız' : 'Star')) : '-')  + '</p>';
                            i++;
                        }
                        answersContent += '</span>';
                    } else {
                        answersContent += '<span class="list-group-item"><h4 class="list-group-item-heading">' + questions[index + 1]['question'][language] + '</h4><p class="list-group-item-text"><strong>Cevap: </strong>' + item + '</p></span>';
                    }
                });
                answersContent += '</div>';
            }
            $('#answersModal').find('.modal-body').html(answersContent);
        });
        $(document).on("click", '.filterButton', function(event) {
            event.preventDefault();
            var sort = $("select#sort").val();
            var regexpNumeric = /[^0-9]/g;
            var regexpAlphaNumeric = /[^a-z0-9]/g;
            var filter = $("input[name='filter']:checked").attr("id");
            $.ajax({
                url: "access-logs?sort="+sort.replace(regexpNumeric,'')+"&filter="+filter.replace(regexpAlphaNumeric,''),
                type: "POST",
                contentType: false,
                cache: false,
                processData:false,
                headers : {
                    'csrftoken': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function()
                {
                    $('.page-loader-wrapper').fadeIn(100);
                },
                success: function(data)
                {
                    $(".accessLogs").html(data);
                    $('.page-loader-wrapper').fadeOut();
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                }
            });
        });
    });
    function copyToClipboard(id) {
        var copyText = document.getElementById(id);
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand('copy');
        $('#' + id + 'Copied').show().delay(3000).fadeOut('slow');
    }
    function sendMail(id, language, button) {
        var email = $('#' + id).val();
        var resultArea = $('#' + (language === 'tr' ? 'pollLinkTrSentResult' : 'pollLinkEnSentResult'));
        resultArea.hide();
        if (email === '') {
            resultArea.show();
            resultArea.html('<strong class="text-danger">Lütfen e-posta adresi giriniz.</strong>');
            return;
        }
        $(button).prop('disabled', true);
        $(button).text('Gönderiliyor...');
        $.ajax({
            url: "send-mail",
            data: 'email=' + email + '&language=' + language,
            type: "POST",
            dataType: 'json',
            cache: false,
            headers : {
                'csrftoken': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data)
            {
                resultArea.show();
                $(button).prop('disabled', false);
                $(button).text('Gönder');
                if (data.success) {
                    $('#' + id).val('');
                    resultArea.html('<strong class="text-success">E-posta başarıyla gönderildi.</strong>');
                } else {
                    resultArea.html('<strong class="text-danger">' + data.message + '</strong>');
                }
            }
        });
    }
    function toggleVisibility(_this, input) {
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            $(_this).text('visibility_off');
        } else {
            input.attr('type', 'password');
            $(_this).text('visibility');
        }
    }
    $("#passwordVisibilityChanger").on('click', function(e) {
        toggleVisibility(this, $('#password'));
    });
    $("#passwordVerifyVisibilityChanger").on('click', function(e) {
        toggleVisibility(this, $('#passwordVerify'));
    });
    $("#profileSettingsForm").on('submit',(function(e)
    {
        e.preventDefault();

        $("#result").empty();

        $('#editProfileButton').prop('disabled', true);
        $('#editProfileButton').html("Kaydediliyor...");


        var password = $("#password").val();
        var passwordVerify = $("#passwordVerify").val();

        if(password.length > 0)
        {
            if(password.length < 6 || password.length > 29)
            {
                $("#result").html("<div class='alert alert-danger'>Yeni şifreniz en az 6 karakter, en fazla 30 karakterden oluşabilir.</div>");
                $('#editProfileButton').prop('disabled', false);
                $('#editProfileButton').html("Kaydet");
                $("#password").val("");
                $("#passwordVerify").val("");
                return false;
            }
        }
        if(password.length > 0 && passwordVerify.length > 0)
        {
            if (password != passwordVerify)
            {
                $("#result").html("<div class='alert alert-danger'>Girdiğiniz şifreler birbirleriyle eşleşmiyor.</div>");
                $('#editProfileButton').prop('disabled', false);
                $('#editProfileButton').html("Edit User");
                $("#password").val("");
                $("#passwordVerify").val("");
                return false;
            }
        }

        $.ajax({
            url: "edit-profile-a",
            type: "POST",
            data:  new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            headers : {
                'csrftoken': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data)
            {
                if(data.success) {
                    if (data.isPasswordChanged) {
                        $("#result").html("<div class='alert alert-success'>Profil ayarlarınız başarıyla kaydedildi. Şifrenizi değiştirdiğiniz için tekrardan giriş ekranına yönlendiriliyorsunuz...</div>");
                        setTimeout(function () { window.location.href = 'home'; }, 3000);
                    } else {
                        $("#result").html("<div class='alert alert-success'>Profil ayarlarınız başarıyla kaydedildi.</div>");
                    }
                    $("#password").val("");
                    $("#passwordVerify").val("");
                } else {
                    $("#result").html("<div class='alert alert-danger'>" + data.message + "</div>");
                }
                $('#editProfileButton').prop('disabled', false);
                $('#editProfileButton').html("Kaydet");
            }
        });
    }));
</script>
<?php } ?>