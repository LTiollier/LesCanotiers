export function getFilters(filterName) {
    return window.axios.get('/filters/' + filterName);
}

export function storeFilter(params) {
    return window.axios.post('/filters', params);
}

export function deleteFilter(filterId) {
    return window.axios.delete('/filters/' + filterId);
}

export function getModelFiltered(params) {
    return window.axios.post('/filters/filter', params);
}
