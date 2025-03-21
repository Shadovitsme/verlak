export default async function getExecData(api, byWhatChoose, column, where) {
    try {
        const response = await fetch(api, {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                byWhatChoose: byWhatChoose,
                column: column,
                where: where,
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
