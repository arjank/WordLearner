;(function(w, $){
    var currentPhrase,
        phrases,
        totalPhrases,
        attempts,
        successClass = 'alert-success',
        successShowDuration = 650,
        errorClass = 'alert-warning',
        errorShowDuration = 1250,
        $question,
        $answer,
        $remark,
        $attempts,
        $messageBox;

    function loadPhrases(url) {
        var ajaxSettings;

        ajaxSettings = {
            url: url,
            type: 'GET',
            async: false,
            dataType: 'json'
        };

        $.ajax(
            ajaxSettings
        ).done(function(data, status, xhr){
            phrases = data;
            totalPhrases = phrases.length;
        }).fail(function(){
            alert('Could not load phrases');
        });
    }

    function checkAnswer() {
        if ($answer.val() === currentPhrase.answer) {
            //$messageBox.removeClass(errorClass).addClass(successClass);
            //$messageBox.text('Correct').slideDown('fast');
            //setTimeout(function(){$messageBox.slideUp('fast', showNextQuestion);}, successShowDuration);
            console.log('success');
            $answer.parents('.form-group').addClass('highlight-success');
            //.removeClass(
            //    'answer-correct',
            //    {duration: 500, complete: showNextQuestion}
            //);
        } else {
            phrases.push(currentPhrase);
            $messageBox.removeClass(successClass).addClass(errorClass);
            $messageBox.text('The correct answer was: ' + currentPhrase.answer).slideDown('fast');
            setTimeout(function(){$messageBox.slideUp('fast', showNextQuestion);}, errorShowDuration);
        }
    }

    function showNextQuestion() {
        if (phrases.length > 0) {
            currentPhrase = phrases.shift();

            $question.text(currentPhrase.question);
            $answer.val('');
            $remark.text(currentPhrase.remark);
            updateAttempts();
        } else {
            showResults();
        }
    }

    function showResults() {
        var msgClass;

        $messageBox.removeClass(successClass).removeClass(errorClass);
        $messageBox.text('You needed ' + attempts + ' attempts to answer ' + totalPhrases + ' phrases correctly.');

        if (attempts === totalPhrases) {
            msgClass = 'alert-success';
        } else if (attempts / totalPhrases < 1.1) {
            msgClass = 'alert-warning';
        } else {
            msgClass = 'alert-danger';
        }

        $answer.prop('disabled', 'disabled');
        $messageBox.addClass(msgClass).slideDown('fast');
    }

    function updateAttempts() {
        attempts = attempts + 1;
        $attempts.text(attempts);
    }

    function start() {
        showNextQuestion();
        $answer.focus();
    }

    function init(params) {
        var url, $phrases;

        url = params.baseUrl + params.chapter + '/' + params.reversed;
        loadPhrases(url);
        attempts = 0;

        $question = $('#question');
        $answer = $('#answer');
        $remark = $('#remark');
        $attempts = $('#attempts');
        $messageBox = $('#messageBox');
        $messageBox.hide();

        $answer.on('keydown', function(event){
            if (event.which == 13) {
                event.preventDefault();
                checkAnswer();
            }
        });

        $phrases = $('#phrases');
        $phrases.text(phrases.length);
        $attempts.text(attempts);
        $phrases.parents('.invisible').removeClass('invisible');
    }

    w.WLQuiz = {
        init: init,
        start: start
    }

}(window, jQuery));
