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
    if (data.error) {
        alert(data.message);
    }
    console.log(data);
}

function formPollUserSubmitError(jqXHR, textStatus, errorThrown)
{
    console.log(textStatus, errorThrown);
}