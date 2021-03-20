export function getFilters(filterName) {
    return window.axios.get(route('filters.index', {filter_name: filterName}).url());
}

export function storeFilter(params) {
    return window.axios.post(route('filters.store').url(), params);
}

export function deleteFilter(filterId) {
    return window.axios.delete(route('filters.destroy', {filter: filterId}).url());
}

export function getModelFiltered(params) {
    return window.axios.post(route('filters.filter').url(), params);
}
