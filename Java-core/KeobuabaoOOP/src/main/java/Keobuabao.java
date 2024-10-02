
import java.util.Scanner;

class Keobuabao {

    private String computerpick;
    String userpick;
    String result;

    public Keobuabao(String computerpick) {
        this.computerpick = computerpick;
    }

    public Keobuabao() {
    }

    //random ket qua cua may tinh
    public String getcomputerpick() {
        int randomNumber = (int) (Math.random() * 3 + 1);
        if (randomNumber == 1) {
            this.computerpick = "bua";
        } else if (randomNumber == 2) {
            this.computerpick = "keo";
        } else {
            this.computerpick = "bao";
        }
        return computerpick;
    }

    //lay du lieu tu nguoi dung
    public String getuserpick() {
        Scanner input = new Scanner(System.in);
        while (true) {
            System.out.println("Ban muon ra gi? Keo, bua hay bao?");
            userpick = input.nextLine();
            userpick = userpick.toLowerCase();
            if (userpick.equals("keo") || userpick.equals("bua") || userpick.equals("bao")) {
                break;
            } else {
                System.out.println("Vui long nhap lai.");
            }
        }
        return userpick;
    }

    public String getResult(String userpick, String computerpick) {
        if (userpick.equals(computerpick)) {
            return "hoa";
        } else if (userpick.equals("keo") && computerpick.equals("bao")) {
            return "chien thang!";
        } else if (userpick.equals("bua") && computerpick.equals("keo")) {
            return "chien thang!";
        } else if (userpick.equals("bao") && computerpick.equals("bua")) {
            return "chien thang!";
        } else {
            return "thua T_T";
        }
    }

}
