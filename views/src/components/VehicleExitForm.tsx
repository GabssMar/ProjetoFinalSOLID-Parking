import { useState } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { LogOut } from "lucide-react";
import Swal from "sweetalert2";
import { parkingAPI } from "@/services/api";

interface VehicleExitFormProps {
    onSuccess: () => void;
}

export const VehicleExitForm = ({ onSuccess }: VehicleExitFormProps) => {
    const [ticketId, setTicketId] = useState("");
    const [loading, setLoading] = useState(false);

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();

        if (!ticketId) {
            Swal.fire({
                icon: "warning",
                title: "Campo obrigatório",
                text: "Por favor, informe o número do ticket",
            });
            return;
        }

        setLoading(true);
        try {
            const vehicle = await parkingAPI.registerExit(parseInt(ticketId));

            Swal.fire({
                icon: "success",
                title: "Saída registrada!",
                html: `
          <div class="text-left space-y-2">
            <p><strong>Placa:</strong> ${vehicle.plate}</p>
            <p><strong>Duração:</strong> ${vehicle.duration}</p>
            <p class="text-xl font-bold text-green-600">Total: R$ ${vehicle.total_price}</p>
          </div>
        `,
            });

            setTicketId("");
            onSuccess();
        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Erro ao registrar saída",
                text: "Não foi possível registrar a saída. Verifique o número do ticket.",
            });
        } finally {
            setLoading(false);
        }
    };

    return (
        <Card>
            <CardHeader>
                <CardTitle className="flex items-center gap-2">
                    <LogOut className="h-5 w-5" />
                    Registrar Saída
                </CardTitle>
                <CardDescription>Informe o ticket para finalizar a estadia</CardDescription>
            </CardHeader>
            <CardContent>
                <form onSubmit={handleSubmit} className="space-y-4">
                    <div className="space-y-2">
                        <Label htmlFor="ticketId">Número do Ticket</Label>
                        <Input
                            id="ticketId"
                            type="number"
                            placeholder="Ex: 123"
                            value={ticketId}
                            onChange={(e) => setTicketId(e.target.value)}
                        />
                    </div>
                    <Button type="submit" variant="destructive" className="w-full" disabled={loading}>
                        {loading ? "Registrando..." : "Registrar Saída"}
                    </Button>
                </form>
            </CardContent>
        </Card>
    );
};
