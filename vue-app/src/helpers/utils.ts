import { ref, customRef } from 'vue'

const debounce = (fn, msDelay = 0) => {
    let timeout
    return (...args) => {
        if (!timeout) {
            fn(...args)
        }
        clearTimeout(timeout)

        timeout = setTimeout(() => {
            fn(...args)
        }, msDelay)
    }
}

export const useDebounce = (initialValue, msDelay) => {
    const state = ref(initialValue)
    return customRef((track, trigger) => ({
        get() {
            track()
            return state.value
        },
        set: debounce(
            value => {
                state.value = value
                trigger()
            },
            msDelay
        ),
    }))
}
