export interface Response {
    success:boolean,
    message?:string|null,
    data?:any|null,
    error?:object|null
}