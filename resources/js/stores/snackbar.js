export const snackbar = {
    state: {
        snackbar: {
            queue: [],
            availableTypes: ['success', 'error', 'info'],
            trigger: 0
        }
    },
    mutations: {
        setSnackbar: (state, data) => {
            if(data.message) {
                let snackbar = {
                    message: data.message,
                    type: data.type && state.snackbar.availableTypes.indexOf(data.type) !== -1 ? data.type: 'info',
                    timestamp: Date.now()
                };
                let length = state.snackbar.queue.length;
                state.snackbar.queue.push(snackbar);
                if(length === 0) { state.snackbar.trigger ++; }
            }
        },
        shiftQueue: (state) => {
            if(state.snackbar.queue.length) {
                state.snackbar.queue.shift();
                state.snackbar.trigger ++;
            }
        }
    },
    getters: {
        getFirstSnackbar: (state) => {
            return state.snackbar.queue[0];
        }
    }
};