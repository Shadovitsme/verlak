export default async function getDataForTableFill() {
    try {
        const response = await fetch('/user', {
            method: 'GET',
            headers: {
                Accept: 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        let unassociatedData = [];
        data.forEach((element) => {
            unassociatedData.push(Object.values(element));
        });
        return unassociatedData; // Возвращаем данные как массив
    } catch (error) {
        console.error('Error fetching data:', error);
        throw error;
    }
}
