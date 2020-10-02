module.exports = {
    games: {
        siege: "Rainbow Six Siege (R6S)",
        hyperscape: "Hyper Scape",
        fallguys: "Fall Guys",
        apex: "Apex Legends",
        valorant: "Valorant",
        fortnite: "Fortnite",
        bfv: "Battlefield V (BFV)",
        pubg: "PLAYERUNKNOWN\"S BATTLEGROUNDS (PUBG)",
        deceit: "Deceit",
        other: "その他 (Other)",
    },
    types: {
        imb: "一時メンバー募集",
        kmb: "固定メンバー募集",
        cmb: "クランメンバー募集",
        ims: "一時メンバー参加希望",
        kms: "固定メンバー参加希望",
        cms: "クランメンバー参加希望",
        other: "その他 (Other)",
    },

    reactSelectOptions: {
        platforms: [
            {
                label: "パソコン (PC)",
                value: "pc",
            },
            {
                label: "モバイル (Mobile)",
                value: "mobile",
            },
            {
                label: "Play Station 3 (PS3)",
                value: "ps5",
            },
            {
                label: "Play Station 4 (PS4)",
                value: "ps4",
            },
        ],
        games: [
            {
                label: "人気ゲーム",
                options: [
                    {
                        label: "Rainbow Six Siege (R6S)",
                        value: "siege"
                    },
                    {
                        label: "Apex Legends",
                        value: "apex"
                    },
                    {
                        label: "Fall Guys: Ultimate Knockout",
                        value: "fallguys"
                    },
                ]
            },
            {
                label: "タクティカルシューター",
                options: [
                    {
                        label: "Rainbow Six Siege (R6S)",
                        value: "siege"
                    },
                    {
                        label: "Valorant",
                        value: "valorant"
                    },
                ]
            },
            {
                label: "バトルロワイアル",
                options: [
                    {
                        label: "Apex Legends",
                        value: "apex"
                    },
                    {
                        label: "Fortnite",
                        value: "fortnite"
                    },
                    {
                        label: "Hyper Scape",
                        value: "hyperscape"
                    },
                    {
                        label: "PLAYERUNKNOWN'S BATTLEGROUNDS (PUBG)",
                        value: "pubg"
                    },
                    {
                        label: "Fall Guys: Ultimate Knockout",
                        value: "fallguys"
                    },
                ]
            },
            {
                label: "サバイバル",
                options: [
                    {
                        label: "Minecraft",
                        value: "minecraft"
                    },
                    {
                        label: "Rust",
                        value: "rust"
                    },
                ]
            },
            {
                label: "心理ゲーム",
                options: [
                    {
                        label: "Deceit",
                        value: "deceit"
                    },
                ]
            },
            {
                label: "その他 (Other)",
                value: "other"
            }
        ],
        types: [
            {
                label: "募集",
                options: [
                    {
                        label: "一時(即席)メンバー募集",
                        value: "imb"
                    },
                    {
                        label: "固定メンバー募集",
                        value: "kmb"
                    },
                    {
                        label: "クランメンバー募集",
                        value: "cmb"
                    },
                ]
            },
            {
                label: "志願",
                options: [
                    {
                        label: "一時(即席)メンバー志願",
                        value: "imb"
                    },
                    {
                        label: "固定メンバー志願",
                        value: "kmb"
                    },
                    {
                        label: "クランメンバー志願",
                        value: "cmb"
                    },
                ]
            },
            {
                label: "その他 (Other)",
                value: "other"
            }
        ]
    }
}
