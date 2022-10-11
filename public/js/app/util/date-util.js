function formatDate(date)
{
    if(date) {
        return (
            [
                date.getFullYear(),
                date.getMonth() + 1,
                ('0'+date.getDate()).slice(-2),
            ].join('-') +
            ' ' +
            [
                date.getHours(),
                date.getMinutes(),
                date.getSeconds(),
            ].join(':')
        );
    }
    return '';
}

function getDateByString(dateString)
{
    return dateString ? new Date(dateString) : null;
}