export function getFilters(filterName) {
    return window.axios.get(route('json.filters.index', {filter_name: filterName}));
}

export function storeFilter(params) {
    return window.axios.post(route('json.filters.store'), params);
}

export function deleteFilter(filterId) {
    return window.axios.delete(route('json.filters.destroy', {filter: filterId}));
}

export function getModelFiltered(params) {
    return window.axios.post(route('json.filters.filter'), params);
}
