export interface Response {
    success:boolean,
    message?:string|null,
    data?:any|null,
    error?:object|null
}


export interface QueueDetails {
    id:number,
    price:number,
    period:number,
    description:string,
}

export interface Queue {
    id:number,
    number:number,
    status:string,
    status_id:number,
    location_id:number,
    is_expired:boolean,
    started_at:string,
    end_at:string,
    missing_at:string,
    startable:boolean,
    endable:boolean,
    editable:boolean,
    deletable:boolean,
    detail?:QueueDetails

}