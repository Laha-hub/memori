validateForm();

function validateForm() {
    const $inputs = document.querySelectorAll('.validate-target');
    const $forms = document.querySelectorAll('.validate-form');

    if(!$forms) {
        return;
    }

    for(const $input of $inputs) {

        $input.addEventListener('input', function(event) {
            const $target = event.currentTarget; //currentTargetにイベント検知されたDOMを格納
            const $feedback = $target.nextElementSibling;

            activateSubmitBtn($forms);

            if(!$feedback.classList.contains('invalid-feedback')) {
                return;
            }

            if($target.checkValidity()) {
                $target.classList.add('is-valid');
                $target.classList.remove('is-invalid');

                $feedback.textContent = '';

            } else {
                $target.classList.add('is-invalid');
                $target.classList.remove('is-valid');

                if($target.validity.valueMissing) {
                    $feedback.textContent = '値の入力が必須です。';
                } else if ($target.validity.tooShort) {
                    $feedback.textContent = $target.minLength + '文字以上で入力してください。現在の文字数は ' + $target.value.length + ' 文字です。';
                } else if ($target.validity.tooLong) {
                    $feedback.textContent = $target.maxLength + '文字以下で入力してください。現在の文字数は ' + $target.value.length + ' 文字です。';
                } else if ($target.validity.patternMismatch) {
                    $feedback.textContent = '半角英数字で入力してください。';
                }
            }

        });

    }

    activateSubmitBtn($forms);

}


function activateSubmitBtn($forms) {

    for(const $form of $forms) {

        const $submit_btn = $form.querySelector('[type="submit"]');

        if($form.checkValidity()) {
            $submit_btn.removeAttribute('disabled');
        } else {
            $submit_btn.setAttribute('disabled', true);
        }

    }

}
