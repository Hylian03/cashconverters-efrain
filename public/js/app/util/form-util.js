
function isValidEAN(ean) {
    function testChecksum(ean) {
        const digits = ean.slice(0, -1);
        const checkDigit = ean.slice(-1) | 0;
        let sum = 0;
        for (let i = digits.length - 1; i >= 0; i--) {
            sum += (digits.charAt(i) * (1 + (2 * (i % 2)))) | 0;
        }
        sum = (10 - (sum % 10)) % 10;
        return sum === checkDigit;
    }
    ean = String(ean);
    const isValidLength = ean.length === 18 || ean.length === 14 || ean.length === 13 || ean.length === 8 || ean.length === 5;
    return isValidLength && /^\d+$/.test(ean) && testChecksum(ean);
}

function isValidIMEI (imei) {
    var etal = /^[0-9]{15}$/;
    if (!etal.test(imei))
        return false;
    sum = 0; mul = 2; l = 14;
    for (i = 0; i < l; i++) {
        digit = imei.substring(l-i-1,l-i);
        tp = parseInt(digit,10)*mul;
        if (tp >= 10)
            sum += (tp % 10) +1;
        else
            sum += tp;
        if (mul == 1)
            mul++;
        else
            mul--;
    }
    chk = ((10 - (sum % 10)) % 10);
    if (chk != parseInt(imei.substring(14,15),10))
        return false;
    return true;
}