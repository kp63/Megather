import axios from "axios";

(() => {
  const input = document.getElementById('settings-username-input') as HTMLInputElement | null;
  if (!input)
    return;

  const statusElements: { [key: string]: HTMLElement | null } = {
    ok: document.getElementById('kDosXcdq'),
    invalid: document.getElementById('SoxCmdfF'),
    used: document.getElementById('OdIedXcv'),
  }

  const hideAllStatusElements = () => {
    for (const key in statusElements) {
      statusElements[key]?.classList.remove('shown');
    }
  }

  input.onchange = async () => {

    if (input.value === input.defaultValue) {
      hideAllStatusElements();
      return;
    }

    try {
      const res = await axios.get('/api/username_check', {
        params: {q: input.value}
      });

      hideAllStatusElements();
      switch (res.data) {
        case 'ok':
          statusElements.ok?.classList.add('shown');
          return;
        case 'invalid':
          statusElements.invalid?.classList.add('shown');
          return;
        case 'taken':
          statusElements.used?.classList.add('shown');
          return;
      }
    } catch (e) {
      console.log('Connection Error');
    }
  };
})()
