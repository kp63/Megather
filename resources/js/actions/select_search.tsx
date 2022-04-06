import React from "react";
import { createRoot } from 'react-dom/client';
import Select from "react-select";
import { StylesConfig } from "react-select/dist/declarations/src/styles";

(() => {
  const styles: StylesConfig = {
    control: base => ({
      ...base,
      fontSize: '16px'
    }),
    menu: base => ({
      ...base,
      fontSize: '16px'
    }),
    placeholder: base => ({
      ...base,
      fontSize: '14px'
    }),
  };

  // (() => {
  //   const wrappers = document.querySelectorAll('[data-selector]');
  //
  //   for (let i = 0; i < wrappers.length; i++) {
  //     const wrapper = wrappers[i] as HTMLElement;
  //
  //     const Selector = () => (
  //       <Select name={wrapper.dataset?.name}
  //               isMulti={Boolean(wrapper.dataset?.isMultiple)}
  //               options={wrapper.dataset?.options ? JSON.parse(wrapper.dataset?.options) : {}}
  //               placeholder={wrapper.dataset?.placeholder ?? ''}
  //               styles={styles}
  //       />
  //     );
  //
  //     createRoot(wrapper).render(<Selector />);
  //   }
  // })();

  const getOption = (
    options: { [key: string]: any } | { [key: string]: any }[],
    key: string | null | undefined
  ): { [key: string]: any } | null => {
    if (!key)
      return null;

    if (Array.isArray(options)) {
      for (let i = 0; i < options.length; i++) {
        const optionsItem = options[i];
        const res = getOption(optionsItem, key);
        if (res)
          return res;
      }
    } else {
      if (options?.value === key)
        return options;

      if (options?.options)
        return getOption(options.options, key);
    }

    return null;
  }

  (() => {
    const wrapper = document.getElementById('game-selector');

    if (!wrapper) return;

    const Selector = () => {
      return (
        <Select name={wrapper.dataset?.name ?? 'game'}
                isMulti={Boolean(wrapper.dataset?.isMultiple)}
                options={window.app?.options.games}
                placeholder={"ゲームの選択または検索…"}
                styles={styles}
                defaultValue={(wrapper.dataset?.selected && getOption(window.app?.options.games, wrapper.dataset?.selected))}
        />
      );
    }

    createRoot(wrapper).render(<Selector />);
  })();

  (() => {
    const wrapper = document.getElementById('type-selector');

    if (!wrapper) return;

    const Selector = () => {
      return (
        <Select name={wrapper.dataset?.name ?? 'type'}
                isMulti={Boolean(wrapper.dataset?.isMultiple)}
                options={window.app?.options.types}
                placeholder={"タイプの選択または検索…"}
                styles={styles}
                defaultValue={(wrapper.dataset?.selected && getOption(window.app?.options.types, wrapper.dataset?.selected))}
        />
      );
    }

    createRoot(wrapper).render(<Selector />);
  })();
})();
