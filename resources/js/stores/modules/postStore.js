import http from '../../services';
import {url} from '@/configs/configURL';

const userLocal = JSON.parse(localStorage.getItem('user'));
const token = JSON.parse(localStorage.getItem('token'));

export default {
    state: {
        list_comments: [],
        posts: [],
    },
    mutations: {
        
    },
    actions: {
    }

}