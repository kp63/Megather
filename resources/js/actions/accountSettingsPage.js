(() => {
    let input = document.getElementById('settings-username-input');
    if (!_.isElement(input)) return;

    let els = {
        ok: document.getElementById('kDosXcdq'),
        invalid: document.getElementById('SoxCmdfF'),
        used: document.getElementById('OdIedXcv'),
    }

    let hideAllEls = () => {
        for (const i in els) {
            els[i].classList.remove('shown');
        }
    }

    let checkUsername = async () => {

        if (input.value === input.defaultValue) {
            hideAllEls();
            return;
        }

        try {
            let res = await axios.get('/api/username_check', {params: {q: input.value}});

            hideAllEls();
            switch (res.data) {
                case 'ok':
                    els.ok.classList.add('shown');
                    return;
                case 'invalid':
                    els.invalid.classList.add('shown');
                    return;
                case 'used':
                    els.used.classList.add('shown');
                    return;
            }
        } catch (e) {
            console.log('Connection Error');
        }
    }

    input.oninput = checkUsername;
    input.onchange = checkUsername;
})()

