import React from "react";
import ReactDOM from "react-dom";
import Select from "react-select";

(() => {
    let variables = require('../variables');
    const styles = {
        control: base => ({
            ...base,
            fontSize: '16px'
        }),
        menu: base => ({
            ...base,
            fontSize: '16px'
        })
    };

    (() => {
        let defaultValue = {value: '', label: 'ゲームの選択または検索…', isDisabled: true};

        let parent = document.querySelector('select[name="game"]');
        let Selector = () => {
            return (
                <Select name={"game"} isMulti={parent.multiple} options={variables.reactSelectOptions.games} defaultValue={defaultValue} styles={styles} />
            );
        }

        parent.insertAdjacentHTML('afterend','<div id="iqwdoiqjwd"></div>');
        parent.parentNode.removeChild(parent);
        ReactDOM.render(
            <Selector />,
            document.getElementById('iqwdoiqjwd')
        );
    })();
    (() => {
        let defaultValue = {value: '', label: 'タイプの選択または検索…', isDisabled: true};

        let parent = document.querySelector('select[name="type"]');
        let Selector = () => {
            return (
                <Select name={"type"} options={variables.reactSelectOptions.types} defaultValue={defaultValue} styles={styles} />
            );
        }

        parent.insertAdjacentHTML('afterend','<div id="qwdasovsws"></div>');
        parent.parentNode.removeChild(parent);
        ReactDOM.render(
            <Selector />,
            document.getElementById('qwdasovsws')
        );
    })();
})();
