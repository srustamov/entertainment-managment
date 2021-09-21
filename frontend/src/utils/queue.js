import store from '../store';

export const QUEUE_STATUS_PENDING = 1;
export const QUEUE_STATUS_NOW = 2;
export const QUEUE_STATUS_ENDED = 3;
export const QUEUE_STATUS_MISSING = 4;


export const headers = [
    {text: 'Növbə', value: 'number'},
    {text: 'Tip', value: "type", sortable: false,align:'center'},
    {text: 'Qalan Vaxt', value: "time", sortable: false,align:'center'},
    {text: 'Status', value: "status_id", sortable: true,align:'center'},
    {text: 'Başlama tarixi', value: 'started_at', sortable: true,align:'center'},
    {text: 'Yaradılma tarixi', value: 'created_at',align:'center'},
    //{text: 'Bitmə tarixi', value: 'end_at', sortable: true},
    {text: 'Əməliyyatlar', value: 'actions', sortable: false, align: 'center'},
];


export const useColumns = (columns) => {
    if(columns) {
        store.dispatch('queue/setTableShowColumns',columns)
        return localStorage.setItem('queue_table_columns',JSON.stringify(columns))
    }

    if (localStorage.hasOwnProperty('queue_table_columns')) {
        return JSON.parse(localStorage.getItem('queue_table_columns'))
    }

    return headers.map(h => h.text);
}