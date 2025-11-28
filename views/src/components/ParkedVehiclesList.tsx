import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Car, LogOut, Clock } from "lucide-react";
import { Vehicle } from "@/services/api";
import { formatDistanceToNow } from "date-fns";
import { ptBR } from "date-fns/locale";

interface ParkedVehiclesListProps {
  vehicles: Vehicle[];
  onExit: (plate: string) => void;
  loading?: boolean;
}

export const ParkedVehiclesList = ({ vehicles, onExit, loading }: ParkedVehiclesListProps) => {
  return (
    <Card>
      <CardHeader>
        <CardTitle className="flex items-center gap-2">
          <Car className="h-5 w-5" />
          Veículos Estacionados
        </CardTitle>
        <CardDescription>
          {vehicles.length} {vehicles.length === 1 ? "veículo" : "veículos"} no estacionamento
        </CardDescription>
      </CardHeader>
      <CardContent>
        {vehicles.length === 0 ? (
          <div className="flex flex-col items-center justify-center py-12 text-center">
            <Car className="h-12 w-12 text-muted-foreground mb-4" />
            <p className="text-muted-foreground">Nenhum veículo estacionado no momento</p>
          </div>
        ) : (
          <div className="space-y-3">
            {vehicles.map((vehicle) => (
              <div
                key={vehicle.id}
                className="flex items-center justify-between p-4 rounded-lg border bg-card hover:bg-accent/50 transition-colors"
              >
                <div className="space-y-1">
                  <div className="flex items-center gap-2">
                    <Badge variant="outline" className="font-mono font-bold">
                      {vehicle.plate}
                    </Badge>
                    <span className="font-medium">{vehicle.model}</span>
                  </div>
                  <div className="flex items-center gap-4 text-sm text-muted-foreground">
                    <span className="flex items-center gap-1">
                      <div 
                        className="w-3 h-3 rounded-full border-2" 
                        style={{ backgroundColor: vehicle.color.toLowerCase() }}
                      />
                      {vehicle.color}
                    </span>
                    <span className="flex items-center gap-1">
                      <Clock className="h-3 w-3" />
                      {formatDistanceToNow(new Date(vehicle.entryTime), { 
                        addSuffix: true,
                        locale: ptBR 
                      })}
                    </span>
                  </div>
                </div>
                <Button
                  variant="outline"
                  size="sm"
                  onClick={() => onExit(vehicle.plate)}
                  disabled={loading}
                  className="gap-2"
                >
                  <LogOut className="h-4 w-4" />
                  Saída
                </Button>
              </div>
            ))}
          </div>
        )}
      </CardContent>
    </Card>
  );
};
