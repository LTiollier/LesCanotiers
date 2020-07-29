import moment from 'moment';
moment.locale('fr');
moment.updateLocale('fr', {
    week: {
        dow: 1,
        doy: 4
    }
});
export {moment};

export function parseDate(date) {
    if (!date) return null;
    const [month, day, year] = date.split('/');
    return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
}

export function formatDate(date, outputFormat, inputFormat) {
    if (!date) return null;
    const outputDateFormat = outputFormat || 'DD/MM/YYYY';
    const inputDateFormat = inputFormat || 'YYYY-MM-DD';

    return moment(date, inputDateFormat).format(outputDateFormat);
}

export function parseFrToRequest(date, outputFormat, inputFormat) {
    if (!date) return null;
    const outputDateFormat = inputFormat || 'YYYY-MM-DD';
    const inputDateFormat = outputFormat || 'DD/MM/YYYY';

    return moment(date, inputDateFormat).format(outputDateFormat);
}
