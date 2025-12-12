import { ref } from 'vue';
import axios from 'axios';

export function useFramework() {
    const frameworkVersion = ref(null);
    const frameworkAuthor = ref(null);
    const frameworkName = ref(null);
    const loading = ref(false);
    const error = ref(null);

    const fetchFrameworkData = async () => {
        loading.value = true;
        error.value = null;
        try {
            const res = await axios.get('/web/framework');
            if (res.data.success) {
                frameworkAuthor.value = res.data.frameworkAuthor;
                frameworkName.value = res.data.frameworkName;
                frameworkVersion.value = res.data.frameworkVersion;
            } else {
                error.value = 'Failed to fetch framework data';
            }
        } catch (err) {
            error.value = err.response?.data?.message || 'Unknown error';
        } finally {
            loading.value = false;
        }
    };

    return { frameworkAuthor, frameworkName, frameworkVersion, loading, error, fetchFrameworkData };
}