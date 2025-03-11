// useClickOutside.js
import { onMounted, onUnmounted, ref } from 'vue';

export function useClickOutside() {
    const target = ref(null);

    const handler = (callback) => {
        const listener = (event) => {
            if (target.value && !target.value.contains(event.target)) {
                callback(event);
            }
        };

        onMounted(() => {
            document.addEventListener('click', listener);
        });

        onUnmounted(() => {
            document.removeEventListener('click', listener);
        });
    };

    return { target, handler };
}
