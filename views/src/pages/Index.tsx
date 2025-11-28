import { VehicleEntryForm } from "@/components/VehicleEntryForm";
import { VehicleExitForm } from "@/components/VehicleExitForm";
import { ParkingSquare } from "lucide-react";

const Index = () => {
  const handleSuccess = () => {
    // Optional: Add any success handling logic here if needed
    // For now, the forms handle their own success states with alerts
  };

  return (
    <div className="min-h-screen bg-background">
      <header className="border-b bg-card">
        <div className="container mx-auto px-4 py-6">
          <div className="flex items-center justify-between">
            <div className="flex items-center gap-3">
              <ParkingSquare className="h-8 w-8 text-primary" />
              <div>
                <h1 className="text-3xl font-bold">Parking Manager</h1>
                <p className="text-sm text-muted-foreground">Sistema de Gerenciamento de Estacionamento</p>
              </div>
            </div>
          </div>
        </div>
      </header>

      <main className="container mx-auto px-4 py-8">
        <div className="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
          {/* Entry Section */}
          <section>
            <VehicleEntryForm onSuccess={handleSuccess} />
          </section>

          {/* Exit Section */}
          <section>
            <VehicleExitForm onSuccess={handleSuccess} />
          </section>
        </div>
      </main>

      <footer className="border-t mt-12 py-6">
        <div className="container mx-auto px-4 text-center text-sm text-muted-foreground">
          <p>Parking Manager © 2025 - Sistema de Gerenciamento de Estacionamento</p>
        </div>
      </footer>
    </div>
  );
};

export default Index;
