export function parseTime(time) {
    if (!time) return null;
    const [hour, minute, second] = time.split(':');
    return `${hour}:${minute}`;
}
