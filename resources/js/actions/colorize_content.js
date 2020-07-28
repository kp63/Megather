// (() => {
//     const input = document.getElementById('form-content');
//     if (_.isElement(input)) {
//         console.log(input);
//         let escape_html = function (string) {
//             if(typeof string !== 'string') {
//                 return string;
//             }
//             return string.replace(/[&'`"<>]/g, function(match) {
//                 return {
//                     '&': '&amp;',
//                     "'": '&#x27;',
//                     '`': '&#x60;',
//                     '"': '&quot;',
//                     '<': '&lt;',
//                     '>': '&gt;',
//                 }[match]
//             });
//         }
//         input.onblur = function () {
//             this.innerHTML = escape_html(this.innerText).replace(/(#([^\x00-\x2F\x3A-\x40\x5B-\x5E\x60\x7B-\x7F]+))/g, '<a style="color: #07f;" href="/search?tags=$2" target="_blank">$1</a>');
//         }
//     }
// })()
