export default async function getAllWorkerData() {
    try {
        const response = await fetch('/getAllWorkerData', {
            method: 'GET',
            headers: {
                Accept: 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();

        return data; // Возвращаем данные как массив
    } catch (error) {
        console.error('Error fetching data:', error);
        throw error;
    }
}
