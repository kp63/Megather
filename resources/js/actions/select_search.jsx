import React from "react";
import ReactDOM from "react-dom";
import Select from "react-select";

(() => {
    let variables = require('../variables');
    let games = variables.games;
    let types = variables.types;
    const styles = {
        control: base => ({
            ...base,
            fontSize: '14px'
        }),
        menu: base => ({
            ...base,
            fontSize: '14px'
        })
    };

    (() => {
        let defaultValue = {value: '', label: '（募集ゲーム）', isDisabled: true};
        let options = [defaultValue];
        for (let key in games) {
            options.push({value: key, label: games[key]});
        }

        let parent = document.querySelector('select[name="game"]');
        let Selector = () => {
            return (
                <Select name={"game"} options={options} defaultValue={defaultValue} styles={styles} />
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
        let defaultValue = {value: '', label: '（募集タイプ）', isDisabled: true};
        let options = [defaultValue];
        for (let key in types) {
            options.push({value: key, label: types[key]});
        }

        let parent = document.querySelector('select[name="type"]');
        let Selector = () => {
            return (
                <Select name={"type"} options={options} defaultValue={defaultValue} styles={styles} />
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
