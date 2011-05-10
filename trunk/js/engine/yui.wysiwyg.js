var wysiwygConfig = {
    toolbar: {
        animate: true,
        dompath: true,
        titlebar: 'Edition de contenu',
        draggable: false,
        buttonType: 'advanced',
        buttons: [
            { group: 'fontstyle', label: 'Police d\'écriture',
                buttons: [
                    { type: 'select', label: 'Arial', value: 'fontname', disabled: false,
                        menu: [
                            { text: 'Arial', checked: true },
                            { text: 'Ravie'},
                            { text: 'Rockwell'},
                            { text: 'Arial Black' },
                            { text: 'Comic Sans MS' },
                            { text: 'Courier New' },
                            { text: 'Lucida Console' },
                            { text: 'Tahoma' },
                            { text: 'Times New Roman' },
                            { text: 'Trebuchet MS' },
                            { text: 'Verdana' }
                        ]
                    },
                    { type: 'spin', label: '13', value: 'fontsize', range: [ 9, 75 ], disabled: true }
                ]
            },
            { type: 'separator' },
            { group: 'textstyle', label: 'Style de police',
                buttons: [
                    { type: 'push', label: 'Gras CTRL + SHIFT + B', value: 'bold' },
                    { type: 'push', label: 'Italique CTRL + SHIFT + I', value: 'italic' },
                    { type: 'push', label: 'Souligné CTRL + SHIFT + U', value: 'underline' },
                    { type: 'separator' },
                    { type: 'push', label: 'Subscript', value: 'subscript', disabled: true },
                    { type: 'push', label: 'Superscript', value: 'superscript', disabled: true },
                    { type: 'separator' },
                    { type: 'color', label: 'Couleur', value: 'forecolor', disabled: true },
                    { type: 'color', label: 'Couleur de fond', value: 'backcolor', disabled: true },
                    { type: 'separator' },
                    { type: 'push', label: 'Supprimer le style', value: 'removeformat', disabled: true },
                    { type: 'push', label: 'Voir/cacher les éléments', value: 'hiddenelements' }
                ]
            },
            { type: 'separator' },
            { group: 'alignment', label: 'Alignement',
                buttons: [
                    { type: 'push', label: 'Gauche CTRL + SHIFT + [', value: 'justifyleft' },
                    { type: 'push', label: 'Centrer CTRL + SHIFT + |', value: 'justifycenter' },
                    { type: 'push', label: 'Droite CTRL + SHIFT + ]', value: 'justifyright' },
                    { type: 'push', label: 'Justifié', value: 'justifyfull' }
                ]
            },
            { type: 'separator' },
            { group: 'parastyle', label: 'Style de paragraphe',
                buttons: [
                { type: 'select', label: 'Normal', value: 'heading', disabled: true,
                    menu: [
                        { text: 'Normal', value: 'none', checked: true },
                        { text: 'Titre 1', value: 'h1' },
                        { text: 'Titre 2', value: 'h2' },
                        { text: 'Titre 3', value: 'h3' },
                        { text: 'Titre 4', value: 'h4' },
                        { text: 'Titre 5', value: 'h5' },
                        { text: 'Titre 6', value: 'h6' }
                    ]
                }
                ]
            },
            { type: 'separator' },
            { group: 'indentlist', label: 'Indentatione et listes',
                buttons: [
                    { type: 'push', label: 'Indenté', value: 'indent', disabled: true },
                    { type: 'push', label: 'Non indenté', value: 'outdent', disabled: true },
                    { type: 'push', label: 'Liste non ordonné', value: 'insertunorderedlist' },
                    { type: 'push', label: 'Liste ordonné', value: 'insertorderedlist' }
                ]
            },
            { type: 'separator' },
            { group: 'insertitem', label: 'Eléments',
                buttons: [
                    { type: 'push', label: 'Liens CTRL + SHIFT + L', value: 'createlink', disabled: true },
                    { type: 'push', label: 'Image', value: 'insertimage' }
                ]
            }
        ]
    }
};