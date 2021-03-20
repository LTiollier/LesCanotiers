export function getFilters(filterName) {
    return window.axios.get(route('filters.index', {filter_name: filterName}));
}

export function storeFilter(params) {
    return window.axios.post(route('filters.store'), params);
}

export function deleteFilter(filterId) {
    return window.axios.delete(route('filters.destroy', {filter: filterId}));
}

export function getModelFiltered(params) {
    return window.axios.post(route('filters.filter'), params);
}
