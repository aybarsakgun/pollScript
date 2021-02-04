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
                    answersContent += '<span class="list-group-item"><h4 class="list-group-item-heading">' + questions[index + 1]['question'][language] + '</h4><p class="list-group-item-text"><strong>Cevap: </strong>' + item + '</p></span>';
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
</script>
<?php } ?>