export interface Client {
    id: number;
    name: string;
    card_number: number;
    cars: Car[];
}

export interface Car {
    id: number;
    type: string;
    registered: string;
    ownbrand: boolean;
    accidents: number;
    last_service_name: string | null;
    last_service_date: string | null;
}
