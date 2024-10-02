


//Bước 2:
//
//Tạo phương thức main() bên trong lớp Main.
//Nhận đầu vào số nguyên age từ người dùng và gán cho biến age.
//Gọi phương thức setAge() với đối số age sử dụng đối tượng của Person.
//Gọi phương thức getAge() để truy cập giá trị của trường private.
//In giá trị trả về.
public class Main {

    public static void main(String[] args) {
        Keobuabao game = new Keobuabao();
        String computerpick = game.getcomputerpick();
        String userpick = game.getuserpick();
        System.out.println(computerpick);
        System.out.println(game.getResult(userpick, computerpick));
    }
}