$(document).ready(function() {
    $(".pollquestion-add-answer").on("click", pollquestionAddAnswer);
    $(".pollquestion-del-answer").on("click", pollquestionDelAnswer);
    $("#formPollUser ").on("submit", formPollUserSubmit);
});

function pollquestionAddAnswer(event)
{
    var button = event.currentTarget;
    var $inputGroups = $("input[name='answers[]']").parents(".input-group");
    var $newInputGroup = $($inputGroups[0]).clone(true, true);
    
    $(button).before($newInputGroup);

    var newInput = $newInputGroup.find("input[name='answers[]']")[0];
    newInput.id = "answer" + $inputGroups.length;
    newInput.value = "";
    $(newInput).removeClass("is-invalid");

    $newInputGroup.find(".pollquestion-del-answer").data("answer", $inputGroups.length);
}

function pollquestionDelAnswer(event)
{
    var button = event.currentTarget;
    var answer = $(button).data("answer");
    var $inputGroup = $("input#answer"+answer).parents(".input-group");
    $inputGroup.remove();
}

function formPollUserSubmit(event)
{
    var form = event.currentTarget;

    event.stopPropagation();
    event.preventDefault();

    var postData = new FormData(form);

    $.ajax({
        url: "/widget/polls/send",
        method: "post",
        data: postData,
        processData: false,
        contentType: false,
        dataType: 'text',
        success: formPollUserSubmitSuccess,
        error: formPollUserSubmitError
    });
}

function formPollUserSubmitSuccess(data, textStatus, jqXHR)
{
    data = JSON.parse(data);
    console.log(data);
    if (data.error) {
        alert(data.message);
    } else {
        alert(data.message);
        $("#poll_widget_" + data.poll_id + " .poll-title").after('<div class="alert alert-info">Vous avez déjà répondu au sondage</div>');
        $("#form_poll_user_send").parents(".form-group").remove();
    }
}

function formPollUserSubmitError(jqXHR, textStatus, errorThrown)
{
    console.log(textStatus, errorThrown);
}