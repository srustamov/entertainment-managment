import Vue from "vue";
import $axios from "../plugins/axios";
import {queues} from "@/utils/routes";
import {QUEUE_STATUS_ENDED, QUEUE_STATUS_NOW} from "@/utils/queue";

export default class QueueService {

    constructor(queue) {
        this.queue = queue;
    }

    static make(queue) {
        return new QueueService(queue)
    }

    async start() {
        if (this.queue?.started_at) {
            return this.queue;
        }

        let time = await $axios.get('/time');

        /**@type {Response}*/
        let response = await $axios.put(queues + '/' + this.queue.id, {
            started_at: time,
            status_id: QUEUE_STATUS_NOW
        });

        if (response?.success) {
            return response.data;
        }
    }
    async end() {

        if (this.queue?.end_at) {
            return this.queue;
        }

        let time = await $axios.get('/time');

        /**@type {Response}*/
        let response = await $axios.put(queues + '/' + this.queue.id, {
            end_at: time,
            status_id:QUEUE_STATUS_ENDED
        });

        if (response?.success) {
            return response.data;
        }
    }
    async updateDetail() {

        if (!this.queue?.editable) {
            return this.queue;
        }
        let time = await $axios.get('/time');

        /**@type {Response}*/
        let response = await $axios.put(queues + '/' + this.queue.id, {
            detail: this.queue.detail,
            updated_at:time
        });


        if (response?.success) {
            Vue.$toast.success('Queue info updated')
        } else {
            //Vue.$toast.error(response?.message || 'Queue does not updated')
        }

        if (response?.success) {
            return response.data;
        }
    }
    async remove() {

        if (!this.queue?.deletable) {
            return false;
        }

        /**@type {Response}*/
        let response = await $axios.delete(queues + '/' + this.queue.id);

        if (response?.success) {
            Vue.$toast.success('Queue deleted')
        } else {
            //Vue.$toast.error(response?.message || 'Queue does not deleted')
        }

        return response?.success
    }


}