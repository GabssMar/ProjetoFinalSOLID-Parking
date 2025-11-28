// API Configuration and Service
const API_BASE_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000';

export interface Vehicle {
  ticket_id: number;
  plate: string;
  start_time?: string;
  exit_time?: string;
  total_price?: string;
  duration?: string;
}

class ParkingAPI {
  private async request<T>(
    endpoint: string,
    options?: RequestInit
  ): Promise<T> {
    try {
      const response = await fetch(`${API_BASE_URL}${endpoint}`, {
        headers: {
          'Content-Type': 'application/json',
          ...options?.headers,
        },
        ...options,
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      return await response.json();
    } catch (error) {
      throw error;
    }
  }

  // Register vehicle entry
  async registerEntry(data: {
    plate: string;
    vehicleType: string;
  }): Promise<Vehicle> {
    return this.request<Vehicle>('/api/vehicles/entry', {
      method: 'POST',
      body: JSON.stringify(data),
    });
  }

  // Register vehicle exit
  async registerExit(ticketId: number): Promise<Vehicle> {
    return this.request<Vehicle>('/api/vehicles/exit', {
      method: 'POST',
      body: JSON.stringify({ ticketId }),
    });
  }
}

export const parkingAPI = new ParkingAPI();
