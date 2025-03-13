export default async function addNewContract(
    contractNumber,
    organization,
    date,
    town,
    state,
    tableArrData,
) {
    try {
        const response = await fetch('/addContract', {
            method: 'POST',
            body: JSON.stringify({
                contractNumber: contractNumber,
                organization: organization,
                date: date,
                town: town,
                state: state,
                adressData: tableArrData,
            }),
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content'),
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
    } catch (error) {
        console.error('Error fetching data:', error);
        throw error;
    }
}
