export default async function getExecEntrance(adressId, entranceName) {
    try {
        const response = await fetch('/getExecEntrance', {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                adressId: adressId,
                entranceName: entranceName,
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
