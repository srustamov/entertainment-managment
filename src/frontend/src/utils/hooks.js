export const useFilters = (options) => {

    let filters = {};

    if (options.hasOwnProperty('sortBy')) {
        if (options.sortBy.length) {
            let sort = {};
            sort[options.sortBy[0]] = options.sortDesc[0] ? 'ASC' : 'DESC'
            filters['sort'] = sort;
        }
    }

    filters = {...filters,...options}

    return {
        filters
    }
}