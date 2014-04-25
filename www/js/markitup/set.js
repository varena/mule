myMarkdownSettings = {
    nameSpace:          'markdown', // Useful to prevent multi-instances CSS conflict
    previewParserPath:  '~/../ajax/smartMarkupPreview.php',
    onShiftEnter:       {keepDefault:false, openWith:'\n\n'},
    markupSet: [  
        {name:'Bold', key:"B", openWith:'*', closeWith:'*'},
        {name:'Italic', key:"I", openWith:'**', closeWith:'**'},
        {name:'Strikethrough', key:"S", openWith:'~~', closeWith:'~~'},
        {name:'Marime Text', key:"M", openWith:'&[[![Marimea textului:]!]]', closeWith:'&', placeHolder:'Text'},
        {separator:'---------------' },
        {name:'Block Quote', openWith:'./', closeWith:'/.'},
        {name:'Tabel', openWith:'.[', closeWith:'].'},
        {name:'Linie Tabel', openWith:'.|', closeWith:'|.'},
        {name:'Celula Tabel', openWith:'.-', closeWith:'-.'},
        {separator:'---------------' },
        {name:'Link', key:"L", openWith:'[[![Text]!]]', closeWith:'([![Url:!:http://]!])'},
        {name:'Picture', key:"P", replaceWith:'.([![Url:!:http://]!])'},
        {separator:'---------------'},
        {name:'Preview', call:'preview', className:"preview"}
    ]
}

// Format SmartMarkup:
// *text* - bold
// **text** - italic
// ~~text~~ - strikethrough
// &[size]text& - schimba marimea textului (de exemplu pt headere)
// ./text/. - blockquote
// .[text]. - tabel
/// .|text|. - linie de tabel
/// .-text-. - cell in cadrul liniei
/// [text](URL) - link (ca in Markup)
// .(URL) - afiseaza imaginea aflata la URL

// mIu nameSpace to avoid conflict.
miu = {
    markdownTitle: function(markItUp, char) {
        heading = '';
        n = $.trim(markItUp.selection||markItUp.placeHolder).length;
        for(i = 0; i < n; i++) {
            heading += char;
        }
        return '\n'+heading+'\n';
    }
}