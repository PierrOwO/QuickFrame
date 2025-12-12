import { ref } from 'vue';
import axios from 'axios';

export function useUser() {
    const userFirstName = ref(null);
    const userLastName = ref(null);
    const loading = ref(false);
    const error = ref(null);

    const fetchUser = async () => {
        loading.value = true;
        error.value = null;
        try {
            const res = await axios.get('/web/user');
            if (res.data.success) {
                userFirstName.value = res.data.userFirstName;
                userLastName.value = res.data.userLastName;
            } else {
                error.value = 'Failed to fetch user';
            }
        } catch (err) {
            error.value = err.response?.data?.message || 'Unknown error';
        } finally {
            loading.value = false;
        }
    };

    return { userFirstName, userLastName, loading, error, fetchUser };
}