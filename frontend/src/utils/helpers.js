import _ from "lodash";

export const isRequired = (field,message) => {
    throw new Error(message || `${field} argument is required`);
}


export const search = (array = isRequired('array'), property = isRequired('property'), search = null) => {
    if (_.isNull(search)) {
        return array.filter((item) => {
            return item.toLowerCase().includes(property);
        })
    }

    return array.filter((item) => {
        return item[property].toLowerCase().includes(search);
    })
}