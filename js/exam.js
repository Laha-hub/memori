function incrementFactory() {
    let done_question_count = 0;
    function inc() {
        done_question_count++;
        return done_question_count;
    }
    return inc;
}


printExamAnswerFrontEnd();

function printExamAnswerFrontEnd() {

    const increment = incrementFactory();

    const $answer_btns = document.querySelectorAll('input[name="answer_btn"]');
    const $exam_inputs = document.querySelectorAll('input[name="exam_input"]');
    const $topic_ids = document.querySelectorAll('input[name="topic_id"]');
    const $question_ids = document.querySelectorAll('input[name="question_id"]');
    const $answer_disps = document.querySelectorAll('#answer_disp');


    if($exam_inputs.length === 0) {
        return;
    }

    for(let $i = 0; $i < $answer_btns.length; $i++) {

        $($answer_btns[$i]).on("click", function (event) {

            event.preventDefault();

            const input = $exam_inputs[$i]['value'];
            const topic_id = $topic_ids[$i]['value'];
            const question_id = $question_ids[$i]['value'];
            const url = "libs/print-exam-answer.php?pea=1";

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    input: input,
                    topic_id: topic_id,
                    question_id: question_id,
                },
                dataType: "json",
            })
                .done(function (data) {
                    $answer_disps[$i].append(data.answer_text);
                    $answer_disps[$i].classList.add(data.cls[0], data.cls[1]);
                    $answer_btns[$i].setAttribute('disabled', true);
                    $exam_inputs[$i].setAttribute('disabled', true);
                    activateScoreBtn(increment(), $exam_inputs);
                })
                .fail(function (XMLHttpRequest, status, e) {
                    console.log(XMLHttpRequest);
                    console.log(status);
                    console.log(e);
                });
        });
    }
}


function activateScoreBtn(count, $exam_inputs) {

        const $score_btn = document.querySelector('#score_btn');

        if(!$score_btn) {
            return;
        }

        if(count === $exam_inputs.length) {
            $score_btn.removeAttribute('disabled');
        } else {
            $score_btn.setAttribute('disabled', true);
        }


}
