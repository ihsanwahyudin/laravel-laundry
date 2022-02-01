// REQUIRED JQUERY

// Disable letter
$(document).on('keypress', '.disable-letter', function(e) {
    var ch = String.fromCharCode(e.which)
    if(!(/[0-9]/.test(ch)) && e.keyCode !== 13) {
        e.preventDefault();
    }
});
// Format Number input
let formatHarga;
$(document).on('keyup', '.format-number', function (e) {
    formatHarga = this;
    let value = this.value.replaceAll('.', '');
    let strArray = value.split('');
    for(let i = 0; i <= value.length; i++) {
        if(strArray[i] != '0') {
            formatHarga.value = formatForNumber(value.slice(i));
            break;
        }
    }
});

function formatForNumber(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split       = number_string.split(','),
    sisa         = split[0].length % 3,
    formatHarga    = split[0].substr(0, sisa),
    ribuan         = split[0].substr(sisa).match(/\d{3}/gi);

    if(ribuan){
    let separator = sisa ? '.' : '';
    formatHarga += separator + ribuan.join('.');
    }

    formatHarga = split[1] != undefined ? formatHarga + ',' + split[1] : formatHarga;
    return prefix == undefined ? formatHarga : (formatHarga ? formatHarga : '');
}
