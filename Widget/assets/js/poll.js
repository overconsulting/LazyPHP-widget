$(document).ready(function() {
    $(".pollquestion-add-answer").on("click", pollquestionAddAnswer);
    $(".pollquestion-del-answer").on("click", pollquestionDelAnswer);
});

function pollquestionAddAnswer(event)
{
    var button = event.currentTarget;
    var $inputGroups = $("input[name='answer[]']").parents(".input-group");
    var $newInputGroup = $($inputGroups[0]).clone(true, true);
    
    $(button).before($newInputGroup);
    $newInputGroup.find("input[name='answer[]']")[0].id = "answer" + $inputGroups.length;
    $newInputGroup.find(".pollquestion-del-answer").data("answer", $inputGroups.length);
}

function pollquestionDelAnswer(event)
{
    var button = event.currentTarget;
    var answer = $(button).data("answer");
    var $inputGroup = $("input#answer"+answer).parents(".input-group");
    $inputGroup.remove();
}